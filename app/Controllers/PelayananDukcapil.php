<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\DesaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use GuzzleHttp\Client;
use CodeIgniter\Database\Exceptions\Exception;
use App\Libraries\CIQRCode;



class PelayananDukcapil extends BaseController
{
    protected $kategori;
    protected $desa;
    protected $artikel;
    protected $session;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
        $this->artikel = new ArtikelModel();
        $this->desa = new DesaModel();
        $this->session = session(); // Memulai session
        helper('lokasi_pengambilan_helper');
    }

    public function verifikasi_data()
    {
        $data = [
            'NIK'                       => $this->session->get('NIK'),
            'NAMA_PEMOHON'              => $this->session->get('NAMA_PEMOHON'),
            'ALAMAT'                    => $this->session->get('ALAMAT'),
            'NO_HP'                     => $this->session->get('NO_HP'),
            'EMAIL_TERMOHON'            => $this->session->get('EMAIL_TERMOHON'),
            'TGL_RENCANA_PENGAMBILAN'   => $this->session->get('TGL_RENCANA_PENGAMBILAN'),
        ];

        //start ambil data getuser desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa->find($id);
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa['kode_desa'],
                'namaDesa' => $dataDesa['nama_desa'], 
            ];
        } else {
            $hasil  = 'Data desa tidak ditemukan.';
        }

        $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        //end ambil data getuser desa

        //start get data permohonan hari ini
        $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/permohonanhariini/$getUser";
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($permohonanHariIni);
            $dataPermohonanHarIn = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        //end get data permohonan hari ini

        $data['permHarIn']  = $dataPermohonanHarIn['data'] ?? [] ;
        $data['kategoris']  = $this->kategori->findAll();
        $data['activeTab']  = 'verifikasi-data';

        return view('pelayanandukcapil/layanan/v_verifikasi_data', $data);
    }

    // proses insert form 
    public function verifikasi_detail_permohonan()
    {
        $data = [
            'NIK'                       => $this->request->getPost('NIK'),
            'NAMA_PEMOHON'              => $this->request->getPost('NAMA_PEMOHON'),
            'ALAMAT'                    => $this->request->getPost('ALAMAT'),
            'NO_HP'                     => $this->request->getPost('NO_HP'),
            'EMAIL_TERMOHON'            => $this->request->getPost('EMAIL_TERMOHON'),
            'TGL_RENCANA_PENGAMBILAN'   => $this->request->getPost('TGL_RENCANA_PENGAMBILAN'),
            // Tambahkan variabel lain sesuai kebutuhan
        ];

        $filterData = array_filter($data, function($value) {
            return !is_null($value) && $value !== '';
        });
    
        // Simpan data ke session
        $this->session->set($filterData);

         //start ambil data getuser desa
         $id         = auth()->user()->desa_id;
         $dataDesa   = $this->desa->find($id);
         if (!empty($dataDesa)) {
             $hasil = [
                 'kodeDesa' => $dataDesa['kode_desa'],
                 'namaDesa' => $dataDesa['nama_desa'], 
             ];
         } else {
             $hasil  = 'Data desa tidak ditemukan.';
         }
         $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
         //end ambil data getuser desa

         //start get data permohonan hari ini
        $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/permohonanhariini/$getUser";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($permohonanHariIni);

            // Ambil respons JSON dan ubah menjadi array
            $dataPermohonanHarIn = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        //end get data permohonan hari ini
        $data['permHarIn']      = $dataPermohonanHarIn['data'] ?? [] ;
        $data['permohonanData'] = $this->session->get('permohonan');
        $data['kategoris']      = $this->kategori->findAll();
        $data['activeTab']      = 'verifikasi-data';
        return view('pelayanandukcapil/layanan/v_verifikasi_detail_permohonan', $data);
    }

    function upload_detail_permohonan(){
        $data = $this->request->getPost('data');

        if (!empty($data)) {
            $this->session->set('permohonan', $data);
            return $this->response->setJSON(['message' => 'Data berhasil disimpan!']);
        } else {
            // Kirimkan respons gagal jika tidak ada data
            return $this->response->setJSON(['message' => 'Data tida tersimpan.']);
        }
    }
    
    public function verifikasi_upload_dokumen()
    {
        //start ambil data getuser desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa->find($id);
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa['kode_desa'],
                'namaDesa' => $dataDesa['nama_desa'], 
            ];
        } else {
            $hasil  = 'Data desa tidak ditemukan.';
        }
        $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        //end ambil data getuser desa

        //start get data permohonan hari ini
        $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/permohonanhariini/$getUser";
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($permohonanHariIni);
            $dataPermohonanHarIn = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        //end get data permohonan hari ini

        $data = [
            'JENIS_DOC'             => $this->session->get('JENIS_DOC'),
            'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN'),
            'CATATAN'               => $this->session->get('CATATAN'),
        ];

        $data['permHarIn']  = $dataPermohonanHarIn['data'] ?? [] ;
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';

        return view('pelayanandukcapil/layanan/v_verifikasi_upload_dokumen', $data);
    }

    public function store()
    {
        $client     = new Client();
        //ambil data kode desa dan nama desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa
        // ->select('nama_desa,kode_desa,no_kecamatan,nama_kecamatan')
        ->join('kecamatan', 'kecamatan.no_kecamatan = desa.no_kecamatan')
        ->where('desa.id', auth()->user()->desa_id)
        ->get()
        ->getResult();
    
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa[0]->kode_desa,
                'namaDesa' => $dataDesa[0]->nama_desa, 
                'noKec'    => $dataDesa[0]->no_kecamatan, 
                'namaKec'  => $dataDesa[0]->nama_kecamatan, 
            ];
        } else {
            $hasil = 'Data desa tidak ditemukan.';
        }

        $data = [
            'KD_PENGAMBILAN'     => $dataDesa[0]->no_kecamatan,
            'LOKASI_PENGAMBILAN' => lokasi_pengambilan($dataDesa[0]->no_kecamatan),
        ];

        $filterData = array_filter($data, function($value) {
            return !is_null($value) && $value !== '';
        });
    
        // Simpan data ke session
        $this->session->set($filterData);

        // update upload file
        $fileSatu   = $this->request->getFile('fileUpload1');
        $fileDua    = $this->request->getFile('fileUpload2');

        $detailPermohonan = $this->session->get('permohonan'); //PERMOHONAN_PELAYANAN_DETAIL_V2

        // dd($detailPermohonan);

        
        $dataRow = [
            'NIK'                       => $this->session->get('NIK'), 
            'NAMA_PEMOHON'              => $this->session->get('NAMA_PEMOHON'),
            'ALAMAT'                    => $this->session->get('ALAMAT'),
            'NO_HP'                     => $this->session->get('NO_HP'), 
            'EMAIL_TERMOHON'            => $this->session->get('EMAIL_TERMOHON'),
           // 'TGL_RENCANA_PENGAMBILAN'   => $this->session->get('TGL_RENCANA_PENGAMBILAN'), //bug
            // 'NAMA_TERMOHON'             => $keyPermohonan['NAMA_TERMOHON'], 
            // 'NIK_TERMOHON'              => $keyPermohonan['NIK_TERMOHON'],
            // 'JENIS_DOC'                 => $keyPermohonan['JENIS_DOC'],
            'KD_PENGAMBILAN'            => $this->session->get('KD_PENGAMBILAN'),
            'LOKASI_PENGAMBILAN'        => $this->session->get('LOKASI_PENGAMBILAN'),
            'KD_LOKASI'                 => $hasil['noKec'],
            'LOKASI_DAFTAR'             => 'KALURAHAN '.session()->get('nama_villages'),
            // 'CATATAN'                   => $this->session->get('CATATAN'),
            'CREATED_BY'                => $hasil['kodeDesa'].$hasil['namaDesa'], //PERMOHONAN_PELAYANAN_V2
            'ID_SKOTA'                  => '', //PERMOHONAN_PELAYANAN_V2
            'NO_KEL'                    => session()->get('desa_id'), //PERMOHONAN_PELAYANAN_V2
            'NAMA_KEL'                  => 'KALURAHAN '.session()->get('nama_villages'), //PERMOHONAN_PELAYANAN_V2
            'NO_KEC'                    => $hasil['noKec'], //PERMOHONAN_PELAYANAN_V2
            'NAMA_KEC'                  => 'KAPANEWON '.$hasil['namaKec'], //PERMOHONAN_PELAYANAN_V2
        ];

        // print_r($dataRow).exit();

         // Validasi bahwa detailPermohonan adalah array
        if (!is_array($detailPermohonan) || empty($detailPermohonan)) {
            return redirect()->back()->with('error', 'Data permohonan  tidak valid atau kosong.');
        }

         // Proses penyimpanan data untuk setiap elemen detailPermohonan
         $batchData = [];
         foreach ($detailPermohonan as $keyPermohonan) {
            // Pastikan setiap elemen memiliki data yang dibutuhkan
            if (isset($keyPermohonan['NAMA_TERMOHON'], $keyPermohonan['NIK_TERMOHON'], $keyPermohonan['JENIS_DOC'])) {
                $batchData[] = [
                    'NAMA_TERMOHON'   => $keyPermohonan['NAMA_TERMOHON'], 
                    'NIK_TERMOHON'    => $keyPermohonan['NIK_TERMOHON'],
                    'JENIS_DOC'       => $keyPermohonan['JENIS_DOC'],
                ];
            }          
        }

        // Periksa apakah file Satu valid
        if (!$fileSatu->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File Satu not found or invalid.'
            ]);
        }

        // Buat array `multipart` untuk Guzzle
        $multipartData = [];
        // Tambahkan setiap item data ke dalam array `multipart`
        foreach ($dataRow as $name => $contents) {
            $multipartData[] = [
                'name'     => $name,
                'contents' => $contents
            ];
        }
        // Tambahkan batch data ke multipart
        foreach ($batchData as $row) {
            foreach ($row as $key => $value) {
                $multipartData[] = [
                    'name'     => $key . '[]', // Tambahkan [] untuk data array
                    'contents' => $value,
                ];
            }
        }

        // Tambahkan file satu ke dalam array `multipart`
        $multipartData[] = [
            'name'     => 'FILE_URL',
            'contents' => fopen($fileSatu->getTempName(), 'r'),
            'filename' => $fileSatu->getName(),
        ];

        if ($fileDua && $fileDua->isValid()) {
            $multipartData[] = [
                'name'     => 'FILE_URL2',
                'contents' => fopen($fileDua->getTempName(), 'r'),
                'filename' => $fileDua->getName(),
            ];
        } else {
            // Jika tidak ada file atau tidak valid
            $multipartData[] = [
                'name'     => 'FILE_URL2',
                'contents' => '', // Kosongkan jika file tidak ada
                'filename' => '', // Kosongkan jika file tidak ada
            ];
        }

        try {
            // Buat klien Guzzle
            // Kirim permintaan POST
            $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/upload', [
                'multipart' => $multipartData
            ]);

            // Tampilkan respons dari server
            $status = $response->getBody()->getContents();

            $data = json_decode($status, true);
            if ($data['status'] == 'success') {
                $this->session->remove(['NIK', 'NAMA_PEMOHON','ALAMAT','NO_HP','EMAIL_TERMOHON','TGL_RENCANA_PENGAMBILAN','LOKASI_PENGAMBILAN','CATATAN','permohonan']);
                $param  = str_replace("/", "-", $data['nopend']);
                return redirect()->to(base_url('admin/verifikasi-layanan/' .$param));
                return redirect()->route('admin/verifikasi-layanan/');
            } else {
                return $data['status'];
            }
        } catch (RequestException $e) {
            // Tangkap error
            if ($e->hasResponse()) {
                return 'Error Response: ' . $e->getResponse()->getBody()->getContents();
            }
            return 'Request Error: ' . $e->getMessage();
        }
    }
    
    public function progres_pelayanan()
    {
        //start ambil data getuser desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa->find($id);
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa['kode_desa'],
                'namaDesa' => $dataDesa['nama_desa'], 
            ];
        } else {
            $hasil  = 'Data desa tidak ditemukan.';
        }
        $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        //end ambil data getuser desa

        $progresPel = "https://dev-smart.gunungkidulkab.go.id/api/progrespelayanan/$getUser";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($progresPel);

            // Ambil respons JSON dan ubah menjadi array
            $dataProgresPel = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }

        $data['progPel']    = $dataProgresPel['data'] ?? [] ;
        $data['kategoris']  = $this->kategori->findAll();
        $data['activeTab']  = 'progres-pelayanan';
        return view('pelayanandukcapil/layanan/v_progres_pelayanan', $data);
    }   
    
    public function siap_ambil()
    {
        // ambil data getuser desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa->find($id);
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa['kode_desa'],
                'namaDesa' => $dataDesa['nama_desa'], 
            ];
        } else {
            $hasil  = 'Data desa tidak ditemukan.';
        }
        $getUser        = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        $getKodeDesa    = $dataDesa['kode_desa'];

        $siapAmbil = "https://dev-smart.gunungkidulkab.go.id/api/siapambil/$getKodeDesa";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($siapAmbil);

            // Ambil respons JSON dan ubah menjadi array
            $dataSiapAmbil = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }

        $data['dtSiapAmbil']  = $dataSiapAmbil['data'] ?? [] ;
        $data['kategoris']    = $this->kategori->findAll();
        $data['activeTab']    = 'siap-ambil';
        return view('pelayanandukcapil/layanan/v_siap_ambil', $data);
    } 

    public function detail_siap_ambil($nopend)
    {
        
        $getVerif = "https://dev-smart.gunungkidulkab.go.id/api/detailsiapambil/$nopend";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response   = $client->get($getVerif);
            $dataDetail = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        $data['dtCekSiapAmbil'] = $dataDetail['data'] ?? [] ;
        $data['kategoris']      = $this->kategori->findAll();
        $data['activeTab']      = 'cek-verifikasi-layanan';
        return view('pelayanandukcapil/layanan/v_detail_siap_ambil', $data);
    }
    
    public function get_siap_ambil($nopend)
    {
        // ambil data getuser desa
        $id         = auth()->user()->desa_id;
        $dataDesa   = $this->desa->find($id);
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa['kode_desa'],
                'namaDesa' => $dataDesa['nama_desa'], 
            ];
        } else {
            $hasil  = 'Data desa tidak ditemukan.';
        }
        $getUser        = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        $getKodeDesa    = $dataDesa['kode_desa'];

        $siapAmbil = "https://dev-smart.gunungkidulkab.go.id/api/siapambil/$getKodeDesa";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($siapAmbil);
            $dataSiapAmbil = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }

        $data['dtSiapAmbil']    = $dataSiapAmbil['data'] ?? [] ;
        $data['kategoris']      = $this->kategori->findAll();
        $data['activeTab']      = 'siap-ambil';
        return view('pelayanandukcapil/layanan/v_siap_ambil', $data);
    }    
    
    public function verifikasi_layanan($nopend)
    {
        $getVerif = "https://dev-smart.gunungkidulkab.go.id/api/getverifikasi/$nopend";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($getVerif);

            // Ambil respons JSON dan ubah menjadi array
            $dataGetVerif = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        
        $data = [
            'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN')
        ];
        $data['dtGetVerifMaster']   = $dataGetVerif['data']['param1'] ?? [] ;
        $data['dtGetVerifDetail']   = $dataGetVerif['data']['param2'] ?? [] ;
        $data['activeTab']          = 'verifikasi-layanan';
        return view('pelayanandukcapil/layanan/v_verifikasi_layanan', $data);
    }
    
    public function cek_layanan($nopend)
    {
        //start ambil data getuser desa
        $getVerif = "https://dev-smart.gunungkidulkab.go.id/api/getceklayanan/$nopend";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($getVerif);
            $dataGetVerif = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        
        $data = [
            'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN')
        ];
        $data['dtGetVerifMaster']   = $dataGetVerif['data']['param1'] ?? [] ;
        $data['dtGetVerifDetail']   = $dataGetVerif['data']['param2'] ?? [] ;
        $data['activeTab']          = 'cek-verifikasi-layanan';
        return view('pelayanandukcapil/layanan/v_cek_verifikasi_layanan', $data);
    }
    // end new

    public function previewFile($fileName)
    {
        $hapusEkstensi = pathinfo($fileName, PATHINFO_FILENAME);
        $apiUrl = 'https://dev-smart.gunungkidulkab.go.id/api/getfiles/' . $hapusEkstensi;

        // Inisialisasi cURL
        $curl = curl_init($apiUrl);

        // Konfigurasi cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/pdf'
        ]);

        // Eksekusi cURL
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpStatus === 200) {
            // Kirim file PDF ke browser
            return $this->response->setHeader('Content-Type', 'application/pdf')
                                ->setBody($response);
        } else {
            // Tampilkan pesan error
            return $this->response->setStatusCode(404, 'File not found');
        }
    }
    
    public function simpan_cek_verifikasi_layanan() {
        $dataRow = [
            'no_pend'               => $this->request->getPost('NO_PEND'),
            'kd_lokasi'             => $this->request->getPost('LOKASI_PENGAMBILAN'),
            'lokasi_pengambilan'    => lokasi_pengambilan($this->request->getPost('LOKASI_PENGAMBILAN')),
            'cat'                   => $this->request->getPost('CATATAN'),
        ];   

        $formData = $this->request->getPost('vrf');
        $multipartData = [];
        // Tambahkan setiap item data ke dalam array `multipart`
        foreach ($dataRow as $name => $contents) {
            $multipartData[] = [
                'name'     => $name,
                'contents' => $contents
            ];
        }

		if (!$formData) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $updateData = [];
        foreach ($formData as $data) {
            if (isset($data['no_urut'], $data['status'], $data['ket'])) {
                $updateData[] = [
                    'status' => 1,
                    'keterangan' => $data['ket'],
                    'no_urut' => $data['no_urut'],
                ];
            }
        }

        foreach ($updateData as $row) {
            foreach ($row as $key => $value) {
                $multipartData[] = [
                    'name'     => $key . '[]', // Tambahkan [] untuk data array
                    'contents' => $value,
                ];
            }
        }

        try {
            // Buat klien Guzzle
            $client = new Client();

            // Kirim permintaan POST
            $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/uploadveriflayanan', [
                'multipart' => $multipartData
            ]);

            // Tampilkan respons dari server
            $status = $response->getBody()->getContents();

            // print_r($status).exit();

            $data = json_decode($status, true);
            if ($data['status'] == 'success') {
                return redirect()->route('admin/progres-pelayanan');
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan.',
                    // 'file_name' => $newNameSatu,
                ], 200);
            } else {
                return $data['status'];
            }
        } catch (RequestException $e) {
            // Tangkap error
            if ($e->hasResponse()) {
                return 'Error Response: ' . $e->getResponse()->getBody()->getContents();
            }
            return 'Request Error: ' . $e->getMessage();
        }

	}

    public function cetak()
    {
        $mpdf = new \Mpdf\Mpdf(
            ['format' => [210,148],
            'margin_left'=>5,
            'margin_right'=>5,
            'margin_top'=>2,
            'margin_bottom'=>0,
            'margin_header'=>0,
            'margin_footer'=>0
           ]
        );

        // start
        $no = $this->request->getUri()->getSegment(3);
        // $param              = str_replace("-", "/", $no);
        $client = \Config\Services::curlrequest();

        $master = "https://dev-smart.gunungkidulkab.go.id/api/permohonanmaster/$no";

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($master);

            // Ambil respons JSON dan ubah menjadi array
            $dataMaster = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data master: ' . $e->getMessage(),
            ]);
        }

        $detail = "https://dev-smart.gunungkidulkab.go.id/api/permohonandetail/$no";

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($detail);

            // Ambil respons JSON dan ubah menjadi array
            $dataDetail = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data detail: ' . $e->getMessage(),
            ]);
        }

        $ciqrcode = new CIQRCode();


        $qr['data']         = 'https://dukcapil.gunungkidulkab.go.id/cek-pendaftaran/?nopen=' . trim($no);
        $qr['level']        = 'H';
        $qr['size']         = 10;
        $qr['savename']     = FCPATH . 'qrpelayanan.png';

		$ciqrcode->generate($qr);


        //  dd($dataDetail);
        $data['master']  = $dataMaster['master'] ?? [] ;
        $data['detail']  = $dataDetail['detail'] ?? [] ;
        $html  = view('pelayanandukcapil/layanan/pdf_master', $data);
		$html .= "<pagebreak />";
		$html .= view('pelayanandukcapil/layanan/pdf_detail', $data); 	
        
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output('arjun.pdf','I');
    }
}
