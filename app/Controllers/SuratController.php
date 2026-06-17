<?php

namespace App\Controllers;

use App\Models\SuratModel;
use App\Models\ConfigModel;
use App\Models\TwebPenduduk;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpWord\PhpWord;
use Dompdf\Dompdf;
use App\Models\DesaModel;


class SuratController extends BaseController
{
    protected $suratModel;
    protected $configModel;
    protected $pendudukModel;

    public function __construct()
    {
        helper('date');
        $this->suratModel = new SuratModel();
        $this->configModel = new ConfigModel();
        $this->pendudukModel = new TwebPenduduk();
    }

    public function index()
    {
        $currentUser = auth()->user();
        if ($currentUser->inGroup('superadmin')) {
            $data['surat_keluar'] = $this->suratModel->findAll();
        } else {
            $data['surat_keluar'] = $this->suratModel->where('desa_id', $currentUser->desa_id)->findAll();
        }
        $data['template_surat'] = $this->getAvailableTemplates();

        return view('surat/index', $data);
    }

    public function create($jenis_surat = null)
    {
        $desaModel         = new DesaModel();
        $data['list_desa'] = $desaModel->findAll();

        // Pass both 'list_desa' and 'jenis_surat' to the view
        return view('surat/create', [
            'jenis_surat' => $jenis_surat,
            'list_desa' => $data['list_desa']
        ]);
    }

    public function store()
    {
        $currentUser = auth()->user();
        // Get data from request
        $data = [
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'nama' => $this->request->getPost('nik'),
            'nik' => $this->request->getPost('nik'),
            'jenis_surat' => $this->request->getPost('jenis_surat'),
            // Force desa_id based on current user (non-superadmin)
            'desa_id' => $currentUser->inGroup('superadmin') ? $this->request->getPost('desa_id') : $currentUser->desa_id,
            'keperluan' => $this->request->getPost('keperluan'),
        ];

        // Save the new surat record
        $this->suratModel->save($data);

        // Get the ID of the newly created surat
        $id = $this->suratModel->getInsertID();

        // Fetch the surat data using the ID
        $surat = $this->suratModel->find($id);

        // Export the surat to Word
        return $this->exportWord($surat);
    }


    public function export($id, $format)
    {
        $context = $this->getSuratContext($id);
        if (! $context) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan');
        }

        if (! $this->canAccessSurat($context['surat'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        if ($format == 'word') {
            return $this->exportWord($context['surat']);
        } elseif ($format == 'pdf') {
            return $this->exportPDF($context);
        }

        return redirect()->back()->with('error', 'Format tidak valid');
    }

    public function cetak($id)
    {
        $context = $this->getSuratContext($id);
        if (! $context) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan');
        }

        if (! $this->canAccessSurat($context['surat'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return $this->exportPDF($context);
    }

    private function exportWord($surat)
    {
        helper('url');
        $jenis = (string) ($surat['jenis_surat'] ?? '');
        $templatePath = $this->getTemplatePath($this->getTemplateFilename($jenis));

        if (! is_file($templatePath)) {
            return redirect()->back()->with('error', 'Template surat tidak ditemukan.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        $desaModel = new ConfigModel();
        $desa =   $desaModel->where('desa_id', $surat['desa_id'])->first();
        if (! $desa) {
            $desa = $desaModel->find($surat['desa_id']);
        }
        $penduduk = $this->getPendudukSurat($surat['nik']);

        $templatePlaceholders = $templateProcessor->getVariables();
        $templateValues = $this->getTemplateValues($surat, $penduduk ?? [], $desa ?? []);
        $templateValues = $this->withTemplatePlaceholderDefaults($templatePlaceholders, $templateValues);

        foreach ($this->getTemplatePlaceholdersForRender($templatePlaceholders) as $placeholder) {
            $templateProcessor->setValue($placeholder, $this->resolveTemplateValue($placeholder, $templateValues));
        }

        $filename = 'Surat_' . $jenis . '_' . ($surat['nik'] ?? '') . '.docx';
        $outputDirectory = WRITEPATH . 'cache';
        if (! is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0775, true);
        }

        $outputPath = tempnam($outputDirectory, 'surat_');

        if ($outputPath === false) {
            return redirect()->back()->with('error', 'Gagal menyiapkan file surat.');
        }

        $templateProcessor->saveAs($outputPath);
        $unresolvedPlaceholders = $this->getUnresolvedDocxPlaceholders($outputPath);

        if ($unresolvedPlaceholders !== []) {
            @unlink($outputPath);

            return redirect()->back()->with(
                'error',
                'Masih ada placeholder surat yang belum ter-render: ' . implode(', ', $unresolvedPlaceholders)
            );
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Content-Length: ' . filesize($outputPath));

        readfile($outputPath);
        @unlink($outputPath);
        exit;
        return redirect()->to('admin/surat');
    }

    private function getTemplatePath(string $filename): string
    {
        $paths = [
            FCPATH . 'assets/template/docx/' . $filename,
            FCPATH . 'assets/template/' . $filename,
            ROOTPATH . 'public/assets/template/docx/' . $filename,
            ROOTPATH . 'public/assets/template/' . $filename,
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return $paths[0];
    }

    private function getAvailableTemplates(): array
    {
        $templates = [];
        $paths = [
            FCPATH . 'assets/template/docx/*.docx',
            FCPATH . 'assets/template/*.docx',
            ROOTPATH . 'public/assets/template/docx/*.docx',
            ROOTPATH . 'public/assets/template/*.docx',
        ];

        foreach ($paths as $path) {
            foreach (glob($path) ?: [] as $file) {
                $key = pathinfo($file, PATHINFO_FILENAME);
                $templates[$key] ??= [
                    'jenis_surat' => $key,
                    'nama' => $this->formatTemplateName($key),
                ];
            }
        }

        uasort($templates, static fn($a, $b) => strcasecmp($a['nama'], $b['nama']));

        return array_values($templates);
    }

    private function formatTemplateName(string $template): string
    {
        if ($template === 'template_keterangan') {
            return 'Keterangan';
        }

        if (str_starts_with($template, 'template_')) {
            $template = substr($template, strlen('template_'));
        }

        if (str_starts_with($template, 'surat_')) {
            $template = substr($template, strlen('surat_'));
        }

        return ucwords(str_replace(['_', '-'], ' ', $template));
    }

    private function getTemplateFilename(string $jenisSurat): string
    {
        if ($jenisSurat === '' || $jenisSurat === 'default') {
            return 'template_keterangan.docx';
        }

        if (! preg_match('/^[A-Za-z0-9_-]+$/', $jenisSurat)) {
            return '';
        }

        $filename = basename($jenisSurat) . '.docx';

        if (is_file($this->getTemplatePath($filename))) {
            return $filename;
        }

        return $filename;
    }

    private function getTemplateValues(array $surat, array $penduduk, array $desa): array
    {
        $tanggalSurat = formatDateIndonesian(date('Y-m-d'));
        $ttl = trim(($penduduk['tempatlahir'] ?? '') . ', ' . ($penduduk['tanggallahir'] ?? ''), ' ,');
        $pendidikan = $penduduk['pendidikan_sdg_nama']
            ?? $penduduk['pendidikan_kk_nama']
            ?? '';

        $values = [
            'NOMOR_SURAT' => $surat['nomor_surat'] ?? '',
            'nomor_surat' => $surat['nomor_surat'] ?? '',
            'nomorsurat' => $surat['nomor_surat'] ?? '',
            'NAMA' => $penduduk['nama'] ?? '',
            'nama' => $penduduk['nama'] ?? '',
            'NO_KTP' => $penduduk['nik'] ?? ($surat['nik'] ?? ''),
            'NIK' => $penduduk['nik'] ?? ($surat['nik'] ?? ''),
            'nik' => $penduduk['nik'] ?? ($surat['nik'] ?? ''),
            'NO_KK' => $penduduk['no_kk'] ?? '',
            'TTL' => $ttl,
            'ttl' => $ttl,
            'TEMPATLAHIR' => $penduduk['tempatlahir'] ?? '',
            'tempat_lahir' => $penduduk['tempatlahir'] ?? '',
            'TGLLAHIR' => $penduduk['tanggallahir'] ?? '',
            'TGL_LAHIR' => $penduduk['tanggallahir'] ?? '',
            'tanggal_lahir' => $penduduk['tanggallahir'] ?? '',
            'SEX' => $penduduk['sex_nama'] ?? '',
            'sex' => $penduduk['sex_nama'] ?? '',
            'PEKERJAAN' => $penduduk['pekerjaan_nama'] ?? '',
            'pekerjaan' => $penduduk['pekerjaan_nama'] ?? '',
            'STATUS_KAWIN' => $penduduk['kawin_nama'] ?? '',
            'status_kawin' => $penduduk['kawin_nama'] ?? '',
            'PENDIDIKAN' => $pendidikan,
            'pendidikan' => $pendidikan,
            'AGAMA' => $penduduk['agama_nama'] ?? '',
            'agama' => $penduduk['agama_nama'] ?? '',
            'ALAMAT' => $penduduk['alamat_sekarang'] ?? '',
            'ALAMAT_SEKARANG' => $penduduk['alamat_sekarang'] ?? '',
            'alamat' => $penduduk['alamat_sekarang'] ?? '',
            'alamat_sekarang' => $penduduk['alamat_sekarang'] ?? '',
            'KEPERLUAN' => $surat['keperluan'] ?? '',
            'keperluan' => $surat['keperluan'] ?? '',
            'KETERANGAN' => $surat['keperluan'] ?? '',
            'TUJUAN' => $surat['keperluan'] ?? '',
            'TGL_SURAT' => $tanggalSurat,
            'tanggal' => $tanggalSurat,
            'TAHUN' => date('Y'),
            'tahun' => date('Y'),
            'NAMA_DES' => $desa['nama_desa'] ?? '',
            'NAMA_DESA' => $desa['nama_desa'] ?? '',
            'nama_des' => $desa['nama_desa'] ?? '',
            'nama_desa' => $desa['nama_desa'] ?? '',
            'NAMA_DESA_JAWA' => $desa['nama_desa'] ?? '',
            'NAMA_KEC' => $desa['nama_kecamatan'] ?? '',
            'NAMA_KECAMATAN' => $desa['nama_kecamatan'] ?? '',
            'nama_kec' => $desa['nama_kecamatan'] ?? '',
            'nama_kecamatan' => $desa['nama_kecamatan'] ?? '',
            'NAMA_KAB' => $desa['nama_kabupaten'] ?? '',
            'NAMA_KABUPATEN' => $desa['nama_kabupaten'] ?? '',
            'nama_kab' => $desa['nama_kabupaten'] ?? '',
            'nama_kabupaten' => $desa['nama_kabupaten'] ?? '',
            'KODE_DESA' => $desa['kode_desa'] ?? '',
            'ALAMAT_DES' => $desa['alamat_kantor'] ?? '',
            'alamat_kantor' => $desa['alamat_kantor'] ?? '',
            'ALAMAT_MAIL' => $desa['email_desa'] ?? '',
            'email' => $desa['email_desa'] ?? '',
            'web' => base_url(),
            'NAMA_PAMONG' => $desa['nama_kepala_desa'] ?? '',
            'NAMA_KADES' => $desa['nama_kepala_desa'] ?? '',
            'nama_kades' => $desa['nama_kepala_desa'] ?? '',
            'NIP_PAMONG' => $desa['nip_kepala_desa'] ?? '',
            'nip_pamong' => $desa['nip_kepala_desa'] ?? '',
            'JABATAN' => 'Kepala Desa',
            'jabatan' => 'Kepala Desa',
            'NAMA_KEPALA_CAMAT' => $desa['nama_kepala_camat'] ?? '',
            'NIP_KEPALA_CAMAT' => $desa['nip_kepala_camat'] ?? '',
            'NAMA_AYAH' => $penduduk['nama_ayah'] ?? '',
            'AYAH_NAMA' => $penduduk['nama_ayah'] ?? '',
            'AYAH_NAMA_AYAH' => $penduduk['nama_ayah'] ?? '',
            'AYAH_NIK' => $penduduk['ayah_nik'] ?? '',
            'AYAH_AGAMA' => $penduduk['agama_nama'] ?? '',
            'AYAH_ALAMAT' => $penduduk['alamat_sekarang'] ?? '',
            'AYAH_PEKERJAAN' => $penduduk['pekerjaan_nama'] ?? '',
            'AYAH_PENDIDIKAN' => $pendidikan,
            'AYAH_SEX' => $penduduk['sex_nama'] ?? '',
            'AYAH_STATUS_KAWIN' => $penduduk['kawin_nama'] ?? '',
            'AYAH_TTL' => $ttl,
            'AYAH_USIA' => $this->getAge($penduduk['tanggallahir'] ?? null),
            'AYAH_WARGA_NEGARA' => $penduduk['warganegara_nama'] ?? '',
            'NAMA_IBU' => $penduduk['nama_ibu'] ?? '',
            'IBU_NAMA' => $penduduk['nama_ibu'] ?? '',
            'IBU_NAMA_AYAH' => $penduduk['nama_ayah'] ?? '',
            'IBU_NIK' => $penduduk['ibu_nik'] ?? '',
            'IBU_AGAMA' => $penduduk['agama_nama'] ?? '',
            'IBU_ALAMAT' => $penduduk['alamat_sekarang'] ?? '',
            'IBU_PEKERJAAN' => $penduduk['pekerjaan_nama'] ?? '',
            'IBU_SEX' => $penduduk['sex_nama'] ?? '',
            'IBU_TTL' => $ttl,
            'IBU_USIA' => $this->getAge($penduduk['tanggallahir'] ?? null),
            'IBU_WARGA_NEGARA' => $penduduk['warganegara_nama'] ?? '',
            'WARGA_NEGARA' => $penduduk['warganegara_nama'] ?? '',
            'USIA' => $this->getAge($penduduk['tanggallahir'] ?? null),
        ];

        return $this->withTemplatePlaceholderDefaults($this->getSupportedTemplatePlaceholders(), $values);
    }

    private function withTemplatePlaceholderDefaults(array $placeholders, array $values): array
    {
        foreach ($placeholders as $placeholder) {
            if (array_key_exists($placeholder, $values)) {
                continue;
            }

            $values[$placeholder] = $this->resolveTemplateValue($placeholder, $values);
        }

        return array_map(static fn($value) => (string) $value, $values);
    }

    private function getTemplatePlaceholdersForRender(array $templatePlaceholders): array
    {
        return array_values(array_unique(array_merge($this->getSupportedTemplatePlaceholders(), $templatePlaceholders)));
    }

    private function getUnresolvedDocxPlaceholders(string $filePath): array
    {
        $placeholders = [];

        foreach ($this->getDocxXmlParts($filePath) as $contents) {
            $text = html_entity_decode(strip_tags($contents), ENT_QUOTES | ENT_XML1);
            preg_match_all('/\$\{([^}]+)\}/', $text, $matches);

            foreach ($matches[1] as $placeholder) {
                $placeholders[$placeholder] = true;
            }
        }

        ksort($placeholders);

        return array_keys($placeholders);
    }

    private function getDocxXmlParts(string $filePath): array
    {
        if (class_exists(\ZipArchive::class)) {
            return $this->getDocxXmlPartsFromZipArchive($filePath);
        }

        return $this->getDocxXmlPartsFromUnzip($filePath);
    }

    private function getDocxXmlPartsFromZipArchive(string $filePath): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
        }

        $parts = [];

        for ($index = 0; $index < $zip->numFiles; $index++) {
            $entryName = $zip->getNameIndex($index);
            if (! $entryName || ! preg_match('#^word/(document|header\d+|footer\d+)\.xml$#', $entryName)) {
                continue;
            }

            $contents = $zip->getFromName($entryName);
            if ($contents === false) {
                continue;
            }

            $parts[] = $contents;
        }

        $zip->close();

        return $parts;
    }

    private function getDocxXmlPartsFromUnzip(string $filePath): array
    {
        if (! function_exists('shell_exec')) {
            return [];
        }

        $entryList = shell_exec('unzip -Z1 ' . escapeshellarg($filePath));
        if (! is_string($entryList) || $entryList === '') {
            return [];
        }

        $parts = [];

        foreach (preg_split('/\R/', trim($entryList)) ?: [] as $entryName) {
            if (! preg_match('#^word/(document|header\d+|footer\d+)\.xml$#', $entryName)) {
                continue;
            }

            $contents = shell_exec('unzip -p ' . escapeshellarg($filePath) . ' ' . escapeshellarg($entryName));
            if (is_string($contents) && $contents !== '') {
                $parts[] = $contents;
            }
        }

        return $parts;
    }

    private function getSupportedTemplatePlaceholders(): array
    {
        return [
            '2010',
            'AGAMA',
            'AGAMA_CALON',
            'AGAMA_WALI',
            'ALAMAT',
            'ALAMAT_CALON',
            'ALAMAT_DES',
            'ALAMAT_MAIL',
            'ALAMAT_NIKAH',
            'ALAMAT_SEKARANG',
            'ALAMAT_TERMOHON',
            'ALAMAT_WALI',
            'AYAH_AGAMA',
            'AYAH_ALAMAT',
            'AYAH_NAMA',
            'AYAH_NAMA_AYAH',
            'AYAH_NIK',
            'AYAH_NO_KK',
            'AYAH_PEKERJAAN',
            'AYAH_PENDIDIKAN',
            'AYAH_SEX',
            'AYAH_STATUS_KAWIN',
            'AYAH_TTL',
            'AYAH_USIA',
            'AYAH_WARGA_NEGARA',
            'BIDANG_KEG',
            'BIN',
            'BINTI',
            'HARI',
            'HARI_LAHIR',
            'HARI_MATI',
            'HARI_NIKAH',
            'HUBKEL_BARU1',
            'HUBKEL_BARU2',
            'HUBKEL_BARU3',
            'HUBKEL_BARU4',
            'HUBKEL_BARU5',
            'HUBKEL_BARU6',
            'HUBUNGAN',
            'HUBUNGAN_WALI',
            'HUB_LAPOR',
            'IBU_AGAMA',
            'IBU_ALAMAT',
            'IBU_NAMA',
            'IBU_NAMA_AYAH',
            'IBU_NIK',
            'IBU_PEKERJAAN',
            'IBU_SEX',
            'IBU_TTL',
            'IBU_USIA',
            'IBU_WARGA_NEGARA',
            'IDENTITAS_BEDA',
            'ISTRI_LAMA',
            'JABATAN',
            'JABAT_KEG',
            'JAM_LAHIR',
            'JAM_MATI',
            'JAM_NIKAH',
            'JENIS_KEG',
            'JURUSAN',
            'KARTU_BEDA',
            'KELAMIN_WALI',
            'KELAS',
            'KEPERLUAN',
            'KERJA_CALON',
            'KETERANGAN',
            'KODE_DESA',
            'KUA',
            'LOKASI_KEG',
            'MULAI_BERLAKU',
            'NAMA',
            'NAMA_AYAH',
            'NAMA_BARU',
            'NAMA_BARU1',
            'NAMA_BARU2',
            'NAMA_BARU3',
            'NAMA_BARU4',
            'NAMA_BARU5',
            'NAMA_BARU6',
            'NAMA_BEDA',
            'NAMA_CALON',
            'NAMA_DES',
            'NAMA_DESA',
            'NAMA_DESA_JAWA',
            'NAMA_IBU',
            'NAMA_KAB',
            'NAMA_KABUPATEN',
            'NAMA_KEC',
            'NAMA_KECAMATAN',
            'NAMA_KEPALA_CAMAT',
            'NAMA_LAHIR',
            'NAMA_PAMONG',
            'NAMA_WALI',
            'NIK',
            'NIK_CALON',
            'NIK_LAHIR',
            'NIK_WALI',
            'NIP_KEPALA_CAMAT',
            'NIP_PAMONG',
            'NO',
            'NOMOR_NIKAH',
            'NOMOR_SURAT',
            'NO_DTKS',
            'NO_KK',
            'NO_KTP',
            'PEKERJAAN',
            'PENDIDIKAN',
            'PESERTA_KEG',
            'PRIA_STATUS',
            'PX_HUBUNGAN',
            'PX_NAMA',
            'PX_NIK',
            'PX_TTL',
            'PX_TTL2',
            'RPHURUF',
            'SAKSI_ALAMAT1',
            'SAKSI_ALAMAT2',
            'SAKSI_BARU1',
            'SAKSI_BARU2',
            'SAKSI_PEKERJAAN1',
            'SAKSI_PEKERJAAN2',
            'SAKSI_UMUR1',
            'SAKSI_UMUR2',
            'SEBAB_MATI',
            'SEBAB_WALI',
            'SEKOLAH',
            'SEX',
            'SEX_LAHIR',
            'STATUS_KAWIN',
            'STATUS_PEMOHON',
            'STATUS_TERMOHON',
            'TAHUN',
            'TEMPATLAHIR',
            'TEMPAT_RAWAT',
            'TGLLAHIR',
            'TGLLHR_WALI',
            'TGL_AKHIR',
            'TGL_BARU1',
            'TGL_BARU2',
            'TGL_BARU3',
            'TGL_BARU4',
            'TGL_BARU5',
            'TGL_BARU6',
            'TGL_KEG',
            'TGL_LAHIR',
            'TGL_LAHIR_CALON',
            'TGL_MATI',
            'TGL_NIKAH',
            'TGL_SURAT',
            'TINDAKAN',
            'TOTAL',
            'TPTLHR_WALI',
            'TPT_BARU1',
            'TPT_BARU2',
            'TPT_BARU3',
            'TPT_BARU4',
            'TPT_BARU5',
            'TPT_BARU6',
            'TPT_LAHIR',
            'TPT_LAHIR_CALON',
            'TPT_MATI',
            'TPT_NIKAH',
            'TTL',
            'TUJUAN',
            'USIA',
            'WAKTU',
            'WANITA_STATUS',
            'WARGA_NEGARA',
            'WARGA_NEGARA_CALON',
            'agama',
            'alamat_kantor',
            'alamat_sekarang',
            'email',
            'keperluan',
            'nama',
            'nama_desa',
            'nama_kabupaten',
            'nama_kades',
            'nama_kecamatan',
            'nik',
            'nomor_surat',
            'nomorsurat',
            'pekerjaan',
            'pendidikan',
            'sex',
            'status_kawin',
            'tanggal',
            'tanggal_lahir',
            'tempat_lahir',
            'web',
            ...array_map(static fn($number) => 'PERTANYAAN' . $number, range(1, 44)),
        ];
    }

    private function resolveTemplateValue(string $placeholder, array $values): string
    {
        if (array_key_exists($placeholder, $values)) {
            return $values[$placeholder];
        }

        $upperPlaceholder = strtoupper($placeholder);
        if (array_key_exists($upperPlaceholder, $values)) {
            return $values[$upperPlaceholder];
        }

        $lowerPlaceholder = strtolower($placeholder);
        if (array_key_exists($lowerPlaceholder, $values)) {
            return $values[$lowerPlaceholder];
        }

        $postValue = $this->request->getPost($placeholder)
            ?? $this->request->getPost($upperPlaceholder)
            ?? $this->request->getPost($lowerPlaceholder);

        if ($postValue !== null) {
            return (string) $postValue;
        }

        return '';
    }

    private function getAge(?string $birthDate): string
    {
        if (! $birthDate) {
            return '';
        }

        try {
            return (string) (new \DateTime($birthDate))->diff(new \DateTime())->y;
        } catch (\Exception $e) {
            return '';
        }
    }


    private function exportPDF(array $context)
    {
        $dompdf = new Dompdf();
        $html = view('surat/pdf_template', $context);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $surat = $context['surat'];
        $dompdf->stream('Surat_' . $surat['jenis_surat'] . '_' . $surat['nik'] . '.pdf', ['Attachment' => false]);
        exit;
    }

    private function getSuratContext($id): ?array
    {
        $surat = $this->suratModel->find($id);
        if (! $surat) {
            return null;
        }

        $desa = $this->configModel->where('desa_id', $surat['desa_id'])->first();
        if (! $desa) {
            $desa = $this->configModel->find($surat['desa_id']);
        }

        $penduduk = $this->getPendudukSurat($surat['nik']);

        return [
            'surat' => $surat,
            'desa' => $desa ?? [],
            'penduduk' => $penduduk ?? [],
            'tanggal' => formatDateIndonesian(date('Y-m-d')),
        ];
    }

    private function canAccessSurat(array $surat): bool
    {
        $currentUser = auth()->user();

        return $currentUser->inGroup('superadmin')
            || (int) $surat['desa_id'] === (int) ($currentUser->desa_id ?? 0);
    }

    private function getPendudukSurat(string $nik): ?array
    {
        return $this->pendudukModel
            ->getAllAttributes()
            ->select('tweb_keluarga.no_kk AS no_kk')
            ->join('tweb_keluarga', 'tweb_penduduk.id_kk = tweb_keluarga.id', 'left')
            ->where('tweb_penduduk.nik', $nik)
            ->first();
    }

    public function delete($id)
    {
        $surat = $this->suratModel->find($id);
        if (!$surat) {
            return redirect()->to('/admin/surat')->with('error', 'Surat tidak ditemukan.');
        }
        $currentUser = auth()->user();
        if (! $currentUser->inGroup('superadmin') && (int) $surat['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            return redirect()->to('/admin/surat')->with('error', 'Akses ditolak.');
        }

        if ($this->suratModel->delete($id)) {
            return redirect()->to('/admin/surat')->with('message', 'Surat deleted successfully.');
        } else {
            return redirect()->to('/admin/surat')->with('error', 'Failed to delete Surat.');
        }
    }
}
