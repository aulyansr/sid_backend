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
        $this->exportWord($surat);

        // Redirect to a different page
        return redirect()->to('admin/surat');
    }


    public function export($id, $format)
    {
        $surat = $this->suratModel->find($id);
        if (!$surat) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan');
        }
        $currentUser = auth()->user();
        if (! $currentUser->inGroup('superadmin') && (int) $surat['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        if ($format == 'word') {
            return $this->exportWord($surat);
        } elseif ($format == 'pdf') {
            return $this->exportPDF($surat);
        }

        return redirect()->back()->with('error', 'Format tidak valid');
    }

    private function exportWord($surat)
    {
        helper('url');
        $desa = $this->configModel->find($surat['desa_id']);
        $templates = [
            "template_skck" => "template_skck.docx",
            "surat_ket_rekom_dtks" => "surat_ket_rekom_dtks.docx",
            "surat_permohonan_duplikat_kelahiran" => "surat_permohonan_duplikat_kelahiran.docx",
            "surat_pengantar_nikah_wanita_473" => "surat_pengantar_nikah_wanita_473.docx",
            "surat_ket_imunisasi_caten" => "surat_ket_imunisasi_caten.docx",
            "surat_ket_beda_nama" => "surat_ket_beda_nama.docx",
            "surat_validasi_bapel_jamkesos" => "surat_validasi_bapel_jamkesos.docx",
            "surat_pengantar_isbat_n3_473" => "surat_pengantar_isbat_n3_473.docx",
            "surat_pengantar_nikah_Laki-laki_kristen" => "surat_pengantar_nikah_Laki-laki_kristen.docx",
            "surat_izin_orangtua" => "surat_izin_orangtua.docx",
            "surat_f204" => "surat_f204.docx",
            "surat_ket_kurang_mampu" => "surat_ket_kurang_mampu.docx",
            "surat_tanpa_ikatan" => "surat_tanpa_ikatan.docx",
            "surat_ket_nikah" => "surat_ket_nikah.docx",
            "surat_ket_blm_masuk_database" => "surat_ket_blm_masuk_database.docx",
            "surat_ket_kia" => "surat_ket_kia.docx",
            "surat_ket_kematian_n6_473" => "surat_ket_kematian_n6_473.docx",
            "surat_batal_pindah" => "surat_batal_pindah.docx",
            "surat_f106" => "surat_f106.docx",
            "surat_pengantar_kip" => "surat_pengantar_kip.docx",
            "surat_ket_domisili_usaha" => "surat_ket_domisili_usaha.docx",
            "surat_keterangan_harga_tanah" => "surat_keterangan_harga_tanah.docx",
            "surat_sktm_jamkes_diy" => "surat_sktm_jamkes_diy.docx",
            "surat_f203" => "surat_f203.docx",
            "surat_izin_orangtua_n5_473" => "surat_izin_orangtua_n5_473.docx",
            "surat_wali" => "surat_wali.docx",
            "surat_permohonan_cerai" => "surat_permohonan_cerai.docx",
            "surat_izin_acara" => "surat_izin_acara.docx",
            "surat_f107" => "surat_f107.docx",
            "surat_jalan" => "surat_jalan.docx",
            "surat_ket_pergi_kawin" => "surat_ket_pergi_kawin.docx",
            "surat_ket_rekom_jamkes" => "surat_ket_rekom_jamkes.docx",
            "surat_ket_pengantar" => "surat_ket_pengantar.docx",
            "surat_pengantar_nikah_pria_473" => "surat_pengantar_nikah_pria_473.docx",
            "surat_pengantar_nikah_kristen" => "surat_pengantar_nikah_kristen.docx",
            "surat_pengantar_jasaraharja" => "surat_pengantar_jasaraharja.docx",
            "surat_ket_belum_nikah" => "surat_ket_belum_nikah.docx",
            "surat_f104" => "surat_f104.docx",
            "surat_f105" => "surat_f105.docx",
            "surat_pernyataan_keberadaan_pasutri" => "surat_pernyataan_keberadaan_pasutri.docx",
            "surat_ket_kematian_suami_istri" => "surat_ket_kematian_suami_istri.docx",
            "surat_permohonan_dispensasi_nikah" => "surat_permohonan_dispensasi_nikah.docx",
            "surat_pernyataan_agama" => "surat_pernyataan_agama.docx",
            "surat_izin_keramaian" => "surat_izin_keramaian.docx",
            "surat_ahli_waris" => "surat_ahli_waris.docx",
            "surat_permohonan_akta" => "surat_permohonan_akta.docx",
            "surat_f102" => "surat_f102.docx",
            "surat_permohonan_duplikat_kematian" => "surat_permohonan_duplikat_kematian.docx",
            "surat_pernyataan_jejaka" => "surat_pernyataan_jejaka.docx",
            "surat_ket_numpang_nikah" => "surat_ket_numpang_nikah.docx",
            "surat_keterangan_domisili" => "surat_keterangan_domisili.docx",
            "surat_ket_catatan_kriminal" => "surat_ket_catatan_kriminal.docx",
            "surat_ket_belum_akta_nikah" => "surat_ket_belum_akta_nikah.docx",
            "surat_wali_2" => "surat_wali_2.docx",
            "surat_ket_penduduk" => "surat_ket_penduduk.docx",
            "surat_ket_kehilangan" => "surat_ket_kehilangan.docx",
            "surat_wali_hakim" => "surat_wali_hakim.docx",
            "surat_permohonan_duplikat_surat_nikah" => "surat_permohonan_duplikat_surat_nikah.docx",
        ];

        $jenis = $surat['jenis_surat'];
        if (isset($templates[$jenis])) {
            $templatePath = 'assets/template/docx/' . $templates[$jenis];
        } else {
            // Default template if jenis_surat is not found in the list
            $templatePath = 'assets/template/docx/template_keterangan.docx';
        }
        $penduduk = $this->pendudukModel->getAllAttributes()->where('nik', $surat['nik'])->first();

        $phpWord           = \PhpOffice\PhpWord\IOFactory::load($templatePath);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        $desaModel = new ConfigModel();
        $desa =   $desaModel->where('desa_id', $surat['desa_id'])->first();

        // Replace placeholders with actual data
        $templateProcessor->setValue('nama_kabupaten', $desa['nama_kabupaten']);
        $templateProcessor->setValue('NAMA_KABUPATEN', $desa['nama_kabupaten']);
        $templateProcessor->setValue('nama_kecamatan', $desa['nama_kecamatan']);
        $templateProcessor->setValue('NAMA_KECAMATAN', $desa['nama_kecamatan']);
        $templateProcessor->setValue('NAMA_DESA', $desa['nama_desa']);
        $templateProcessor->setValue('nama_desa', $desa['nama_desa']);
        $templateProcessor->setValue('alamat_kantor', $desa['alamat_kantor']);
        $templateProcessor->setValue('email', $desa['email_desa']);
        $templateProcessor->setValue('web', base_url());
        $templateProcessor->setValue('nomorsurat', $surat['nomor_surat']);
        $templateProcessor->setValue('nomor_surat', $surat['nomor_surat']);
        $templateProcessor->setValue('nama', $penduduk['nama']);
        $templateProcessor->setValue('nik', $penduduk['nik']);
        $templateProcessor->setValue('tempat_lahir', $penduduk['tempatlahir']);
        $templateProcessor->setValue('tanggal_lahir', $penduduk['tanggallahir']);
        $templateProcessor->setValue('sex', $penduduk['sex_nama']);
        $templateProcessor->setValue('pekerjaan', $penduduk['pekerjaan_nama']);
        $templateProcessor->setValue('status_kawin', $penduduk['kawin_nama']);
        $templateProcessor->setValue('pendidikan', $penduduk['pendidikan_nama']);
        $templateProcessor->setValue('agama', $penduduk['agama_nama']);
        $templateProcessor->setValue('alamat_sekarang', $penduduk['alamat_sekarang']);
        $templateProcessor->setValue('keperluan', $surat['keperluan']);
        $templateProcessor->setValue('tanggal', formatDateIndonesian(date('Y-m-d')));
        $templateProcessor->setValue('nama_kades', $desa['nama_kepala_desa']);
        $filename = 'Surat_' . $surat['jenis_surat'] . '_' . $surat['nik'] . '.docx';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $templateProcessor->saveAs('php://output');
        exit;
        return redirect()->to('admin/surat');
    }


    private function exportPDF($surat)
    {
        $dompdf = new Dompdf();
        $html = view('surat/pdf_template', ['surat' => $surat]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('Surat_' . $surat['jenis_surat'] . '.pdf');
        exit;
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
