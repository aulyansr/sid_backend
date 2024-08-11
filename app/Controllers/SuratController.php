<?php

namespace App\Controllers;

use App\Models\SuratModel;
use App\Models\ConfigModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpWord\PhpWord;
use Dompdf\Dompdf;



class SuratController extends BaseController
{
    protected $suratModel;
    protected $configModel;

    public function __construct()
    {
        helper('date');
        $this->suratModel = new SuratModel();
        $this->configModel = new ConfigModel();
    }

    public function index()
    {
        $data['surat_keluar'] = $this->suratModel->findAll();
        return view('surat/index', $data);
    }

    public function create($jenis_surat = null)
    {
        // Kirim data jenis_surat ke tampilan
        return view('surat/create', ['jenis_surat' => $jenis_surat]);
    }

    public function store()
    {
        // Get data from request
        $data = [
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'jenis_surat' => $this->request->getPost('jenis_surat'),
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
        $desa = $this->configModel->find(1);
        if ($surat['jenis_surat'] == "ket_catatan_kriminal") {
            $templatePath = 'assets/template/template_skck.docx';
        } else {
            $templatePath = 'assets/template/template_keterangan.docx';
        }

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($templatePath);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

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
        $templateProcessor->setValue('nomor_surat', $surat['nomor_surat']);
        $templateProcessor->setValue('nama', $surat['nama']);
        $templateProcessor->setValue('nik', $surat['nik']);
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
        if ($this->suratModel->delete($id)) {
            return redirect()->to('/admin/surat')->with('message', 'Surat deleted successfully.');
        } else {
            return redirect()->to('/admin/surat')->with('error', 'Failed to delete Surat.');
        }
    }
}
