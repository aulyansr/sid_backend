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

        $templateValues = $this->getTemplateValues($surat, $penduduk ?? [], $desa ?? []);
        $templateValues = $this->withTemplatePlaceholderDefaults($templateProcessor->getVariables(), $templateValues);

        foreach ($templateProcessor->getVariables() as $placeholder) {
            $templateProcessor->setValue($placeholder, $this->resolveTemplateValue($placeholder, $templateValues));
        }

        $filename = 'Surat_' . $jenis . '_' . ($surat['nik'] ?? '') . '.docx';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $templateProcessor->saveAs('php://output');
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

        return array_map(static fn($value) => (string) $value, $values);
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
