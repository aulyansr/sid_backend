<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\DesaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use GuzzleHttp\Client;
use CodeIgniter\Database\Exceptions\Exception;
// use Dompdf\Dompdf;
// use Dompdf\Options;
// use App\Libraries\Pdf;
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


    // new
    public function verifikasi_data()
    {

        // phpinfo();
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

        $data['permHarIn']  = $dataPermohonanHarIn['data'] ?? [] ;
        // dd($data);
        $data['kategoris']  = $this->kategori->findAll();
        $data['activeTab']  = 'verifikasi-data';

        // dd($data);
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
        $data['permHarIn']  = $dataPermohonanHarIn['data'] ?? [] ;
        $data['permohonanData'] = $this->session->get('permohonan');
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';
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
        
        // echo "<pre>";
        // print_r($data).exit();
        // echo "</pre>";
        // Ambil data dari form
        // $termohon       = $this->request->getPost('NAMA_TERMOHON');
        // $niktermohon    = $this->request->getPost('NIK_TERMOHON');
        // $jenis_doc      = $this->request->getPost('JENIS_DOC');


        // print_r($termohon).exit();
        // $data = [
        //     'termohon'       => $this->request->getPost('NAMA_TERMOHON'),
        //     'niktermohon'    => $this->request->getPost('NIK_TERMOHON'),
        //     'jenis_doc'     => $this->request->getPost('JENIS_DOC'),
        // ];

        // print_r($data).exit();
        // dd($data);
        // Simpan data permohonan di session
        // if ($termohon &&  $niktermohon && $jenis_doc) {
        //     $permohonanData = [];
        //     foreach ($termohon as $index => $value) {
        //         $permohonanData[] = [
        //             'NAMA_TERMOHON' => $value,
        //             'NIK_TERMOHON' => $niktermohon[$index],
        //             'JENIS_DOC' => $jenis_doc[$index]
        //         ];


        //     }

        // $this->session->set('permohonan', $permohonanData);

        // dd($permohonanData).exit();
        
        // }
        
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

        $data = [
            'JENIS_DOC'             => $this->session->get('JENIS_DOC'),
            'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN'),
            'CATATAN'               => $this->session->get('CATATAN'),
        ];

        // dd($data);
        $data['permHarIn']  = $dataPermohonanHarIn['data'] ?? [] ;
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';

        return view('pelayanandukcapil/layanan/v_verifikasi_upload_dokumen', $data);
    }

    public function storeBackup()
    {
        $client = new Client();

        $data = [
            'LOKASI_PENGAMBILAN' => $this->request->getPost('LOKASI_PENGAMBILAN'),
            'LOKASI_PENGAMBILAN' => $this->request->getPost('LOKASI_PENGAMBILAN'),
            'CATATAN'            => $this->request->getPost('CATATAN'),
            // Tambahkan variabel lain sesuai kebutuhan
        ];

        $filterData = array_filter($data, function($value) {
            return !is_null($value) && $value !== '';
        });
    
        // Simpan data ke session
        $this->session->set($filterData);

        $fileSatu   = $this->request->getFile('fileUpload1');
        $fileDua    = $this->request->getFile('fileUpload2');

        $detailPermohonan = $this->session->get('permohonan'); //PERMOHONAN_PELAYANAN_DETAIL_V2

        // dd($detailPermohonan);

        //ambil data kode desa dan nama desa
        $id = auth()->user()->desa_id;
        $dataDesa = $this->desa
        ->where('id', auth()->user()->desa_id)
        ->get()
        ->getResult();
    
        if (!empty($dataDesa)) {
            $hasil = [
                'kodeDesa' => $dataDesa[0]->kode_desa,
                'namaDesa' => $dataDesa[0]->nama_desa, 
                'noKec'    => $dataDesa[0]->no_kecamatan, 
            ];
        } else {
            $hasil = 'Data desa tidak ditemukan.';
        }

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
            'LOKASI_PENGAMBILAN'        => $this->session->get('LOKASI_PENGAMBILAN'),
            'KD_LOKASI'                 => $hasil['noKec'],
            'CATATAN'                   => $this->session->get('CATATAN'),
            'CREATED_BY'                => $hasil['kodeDesa'].$hasil['namaDesa'], //PERMOHONAN_PELAYANAN_V2
            'ID_SKOTA'                  => $hasil['kodeDesa'], //PERMOHONAN_PELAYANAN_V2
        ];

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
                    'NAMA_TERMOHON'             => $keyPermohonan['NAMA_TERMOHON'], 
                    'NIK_TERMOHON'              => $keyPermohonan['NIK_TERMOHON'],
                    'JENIS_DOC'                 => $keyPermohonan['JENIS_DOC'],
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

        // print_r($multipartData).exit();

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

        // Tambahkan file kedua ke array `multipart`
        // $multipartData[] = [
        //     'name'     => 'FILE_URL2',
        //     'contents' => fopen($fileDua->getTempName(), 'r'),
        //     'filename' => $fileDua->getName(),
        // ];
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
                'contents' => '0', // Kosongkan jika file tidak ada
                'filename' => '0', // Kosongkan jika file tidak ada
            ];
        }

        // echo "<pre>";
        // print_r($multipartData).exit();
        // echo "</pre>";

        try {
            // Buat klien Guzzle
            // $client = new Client();

            // Kirim permintaan POST
            $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/upload', [
                'multipart' => $multipartData
            ]);

            // Tampilkan respons dari server
            $status = $response->getBody()->getContents();

            $data = json_decode($status, true);
            if ($data['status'] == 'success') {
                // $this->session->destroy();
                // $sessions = $this->session->get();
                // Mencetak semua data sesi
                // echo '<pre>';
                // print_r($sessions);
                // echo '</pre>';
                return $this->getNopendVerifikasi($id);
                $this->session->remove(['NIK', 'NAMA_PEMOHON','ALAMAT','NO_HP','EMAIL_TERMOHON','TGL_RENCANA_PENGAMBILAN','LOKASI_PENGAMBILAN','CATATAN','permohonan']);
                return redirect()->route('admin/verifikasi-layanan');
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

    public function store()
    {
        $client = new Client();
        //ambil data kode desa dan nama desa
        $id = auth()->user()->desa_id;
        $dataDesa = $this->desa
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
            // 'CATATAN'            => $this->request->getPost('CATATAN'),
            // Tambahkan variabel lain sesua   i kebutuhan
        ];

        // print_r($data).exit();

        $filterData = array_filter($data, function($value) {
            return !is_null($value) && $value !== '';
        });
    
        // Simpan data ke session
        $this->session->set($filterData);

        // update upload file
        $fileSatu   = $this->request->getFile('fileUpload1');
        $fileDua    = $this->request->getFile('fileUpload2');
        // $uploadedFiles = [];

        // Proses file pertama
        // if ($fileSatu->isValid() && !$fileSatu->hasMoved()) {
        //     $fileName = $fileSatu->getRandomName();
        //     $filePath ='uploads/' . $fileName;
        //     $fileSatu->move('uploads', $fileName);
        //     $uploadedFiles['fileSatu'] = $fileName;
        // }

        // Proses file kedua
        // if ($fileDua->isValid() && !$fileDua->hasMoved()) {
        //     $fileName = $fileDua->getRandomName();
        //     $filePath = 'uploads/' . $fileName;
        //     $fileDua->move('uploads', $fileName);
        //     $uploadedFiles['fileDua'] = $fileName;
        // }

        // Simpan file yang diunggah ke sesi
        // session()->set('uploaded_files_temp', $uploadedFiles);
        // update upload file
        // $fileSatu   = $this->request->getFile('fileUpload1');
        // $fileDua    = $this->request->getFile('fileUpload2');

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
            'CATATAN'                   => $this->session->get('CATATAN'),
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
                    'NAMA_TERMOHON'             => $keyPermohonan['NAMA_TERMOHON'], 
                    'NIK_TERMOHON'              => $keyPermohonan['NIK_TERMOHON'],
                    'JENIS_DOC'                 => $keyPermohonan['JENIS_DOC'],
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

        // print_r($multipartData).exit();

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

        // Tambahkan file kedua ke array `multipart`
        // $multipartData[] = [
        //     'name'     => 'FILE_URL2',
        //     'contents' => fopen($fileDua->getTempName(), 'r'),
        //     'filename' => $fileDua->getName(),
        // ];
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

        // echo "<pre>";
        // print_r($multipartData).exit();
        // echo "</pre>";

        try {
            // Buat klien Guzzle
            // $client = new Client();

            // Kirim permintaan POST
            $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/upload', [
                'multipart' => $multipartData
            ]);

            // Tampilkan respons dari server
            $status = $response->getBody()->getContents();

            $data = json_decode($status, true);
            if ($data['status'] == 'success') {
                // $this->session->destroy();
                // $sessions = $this->session->get();
                // Mencetak semua data sesi
                // echo '<pre>';
                // print_r($data['nopend']).exit();
                // echo '</pre>';

            //    return $this->verifikasi_layanan($data['nopend']);
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
        // $this->kategori->find($id);

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
        // dd($getUser);

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

        $data['progPel']  = $dataProgresPel['data'] ?? [] ;
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'progres-pelayanan';

        // dd($data);

        
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

        $data['dtSiapAmbil']   = $dataSiapAmbil['data'] ?? [] ;
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'siap-ambil';
        return view('pelayanandukcapil/layanan/v_siap_ambil', $data);
    } 

    public function detail_siap_ambil($nopend)
    {
        //start ambil data getuser desa
        // $id         = auth()->user()->desa_id;
        // $dataDesa   = $this->desa->find($id);
        // if (!empty($dataDesa)) {
        //     $hasil = [
        //         'kodeDesa' => $dataDesa['kode_desa'],
        //         'namaDesa' => $dataDesa['nama_desa'], 
        //     ];
        // } else {
        //     $hasil  = 'Data desa tidak ditemukan.';
        // }
        // $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        //end ambil data getuser desa

        //start get data permohonan hari ini
        // $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/getverifikasi/$getUser";
        // $param  = str_replace("/", "-", $nopend);
        // print_r($nopend).exit();
        $getVerif = "https://dev-smart.gunungkidulkab.go.id/api/detailsiapambil/$nopend";
        $client = \Config\Services::curlrequest();

        try {
            // Kirim permintaan GET ke API
            $response = $client->get($getVerif);
            // echo "<pre>";
            // print_r($response).exit();
            // echo "</pre>";
            // Ambil respons JSON dan ubah menjadi array
            $dataDetail = json_decode($response->getBody(), true);
            // $data['data']   = $dataDetail['data'] ?? [] ;
            // echo "<pre>";
            // print_r($data).exit();
            // echo "</pre>";
            // $status = $response->getBody()->getContents();

            // $data = json_decode($status, true);
            // return $this->response->setJSON($data);


        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }
        
        // $data = [
        //     'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN')
        // ];
        // $data['dtGetVerifMaster']   = $dataGetVerif['data']['param1'] ?? [] ;
        $data['dtCekSiapAmbil']   = $dataDetail['data'] ?? [] ;
        // $data['file']               = session()->get('uploaded_files_temp');
        // $fileSatu                   = $data['file']['fileSatu'];
        // $data['filePath']           = base_url('uploads/').$fileSatu;
        // echo "<pre>";
        // print_r($data).exit();
        // echo "</pre>";
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'cek-verifikasi-layanan';
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

            // Ambil respons JSON dan ubah menjadi array
            $dataSiapAmbil = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Tangani error
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ]);
        }

        $data['dtSiapAmbil']   = $dataSiapAmbil['data'] ?? [] ;
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'siap-ambil';
        return view('pelayanandukcapil/layanan/v_siap_ambil', $data);
    }    
    
    public function verifikasi_layanan($nopend)
    {
        //start ambil data getuser desa
        // $id         = auth()->user()->desa_id;
        // $dataDesa   = $this->desa->find($id);
        // if (!empty($dataDesa)) {
        //     $hasil = [
        //         'kodeDesa' => $dataDesa['kode_desa'],
        //         'namaDesa' => $dataDesa['nama_desa'], 
        //     ];
        // } else {
        //     $hasil  = 'Data desa tidak ditemukan.';
        // }
        // $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        // print_r($nopend).exit();
        // $param  = str_replace("/", "-", $nopend);
        //end ambil data getuser desa

        //start get data permohonan hari ini
        // $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/getverifikasi/$getUser";

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
        // $data['file']               = session()->get('uploaded_files_temp');
        // $fileSatu                   = $data['file']['fileSatu'];
        // $data['filePath']           = base_url('uploads/').$fileSatu;
        // echo "<pre>";
        // print_r($data).exit();
        // echo "</pre>";
        // $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-layanan';
        return view('pelayanandukcapil/layanan/v_verifikasi_layanan', $data);
    }
    
    public function cek_layanan($nopend)
    {
        //start ambil data getuser desa
        // $id         = auth()->user()->desa_id;
        // $dataDesa   = $this->desa->find($id);
        // if (!empty($dataDesa)) {
        //     $hasil = [
        //         'kodeDesa' => $dataDesa['kode_desa'],
        //         'namaDesa' => $dataDesa['nama_desa'], 
        //     ];
        // } else {
        //     $hasil  = 'Data desa tidak ditemukan.';
        // }
        // $getUser    = $dataDesa['kode_desa'].$dataDesa['nama_desa'];
        //end ambil data getuser desa

        //start get data permohonan hari ini
        // $permohonanHariIni = "https://dev-smart.gunungkidulkab.go.id/api/getverifikasi/$getUser";

        $getVerif = "https://dev-smart.gunungkidulkab.go.id/api/getceklayanan/$nopend";
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
        // $data['file']               = session()->get('uploaded_files_temp');
        // $fileSatu                   = $data['file']['fileSatu'];
        // $data['filePath']           = base_url('uploads/').$fileSatu;
        // echo "<pre>";
        // print_r($data).exit();
        // echo "</pre>";
        // $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'cek-verifikasi-layanan';
        return view('pelayanandukcapil/layanan/v_cek_verifikasi_layanan', $data);
    }
    // end new

    public function previewFile($fileName)
    {
        // $fileName = "2bb5e4.pdf";
        // Hapus ekstensi .pdf
        $hapusEkstensi = pathinfo($fileName, PATHINFO_FILENAME);

        // print_r($hapusEkstensi).exit();
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


    public function simpan_verixxxfikasi_layanan() {

        // $termohon       = $this->request->getPost('NAMA_TERMOHON');
        // $niktermohon    = $this->request->getPost('NIK_TERMOHON');
        // $jenis_doc      = $this->request->getPost('JENIS_DOC');

        $dataRow = [
            'no_pend'   => $this->request->getPost('NO_PEND'),
            'kd_lokasi' => $this->request->getPost('LOKASI_PENGAMBILAN'),
            'cat'       => $this->request->getPost('CATATAN'),
        ];   


        $formData = $this->request->getPost('vrf');
        // $nm_lokasi =$this->request->getPost('LOKASI_PENGAMBILAN');
        // dd($formData);

		// $dt      = $this->input->post('detail');
		// $cat     = $this->input->post('master');
		// $no_pend = $this->input->post('no_pend');
		// $telp = $this->input->post('no_hp');
		// $kd_lokasi = $this->input->post('kd_pengambilan');
        // $nm_lokasi = $this->input->post('nm_pengambilan');
    
		// if($kd_lokasi != '')
        // {
		// $dt_master = array('FLAG_STATUS'=>1,'CATATAN' => $cat,'KD_PENGAMBILAN' => $kd_lokasi,'LOKASI_PENGAMBILAN' => $nm_lokasi);
        // }
    	// else
        // {
        // $dt_master = array('FLAG_STATUS'=>1,'CATATAN' => $cat);
        // }
		// $this->db->where('NO_PEND', $no_pend);
		// $this->db->update('PERMOHONAN_PELAYANAN_V2', $dt_master);
        $multipartData = [];

        // print_r($multipartData).exit();

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
                    'no_pend' => $data['no_pend'],
                    // 'status' => 1,
                    'keterangan' => $data['ket'],
                    'no_urut' => $data['no_urut'],
                ];

                // dd($updateData);
    
                // Perbarui berdasarkan no_urut
                // $vrfModel->update($data['no_urut'], $updateData);
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


        // dd($multipartData);

        try {
            // Buat klien Guzzle
            // $client = new Client();

            // Kirim permintaan POST
            $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/uploadveriflayanan', [
                'multipart' => $multipartData
            ]);

            // Tampilkan respons dari server
            $status = $response->getBody()->getContents();

            $data = json_decode($status, true);
            if ($data['status'] == 'success') {
                // $this->session->destroy();
                // $sessions = $this->session->get();
                // Mencetak semua data sesi
                // echo '<pre>';
                // print_r($sessions);
                // echo '</pre>';
                // $this->session->remove(['NIK', 'NAMA_PEMOHON','ALAMAT','NO_HP','EMAIL_TERMOHON','TGL_RENCANA_PENGAMBILAN','LOKASI_PENGAMBILAN','CATATAN','permohonan']);
                return redirect()->route('admin/verifikasi-layanan');
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

    //     $batchData = [];
    //     foreach ($detailPermohonan as $keyPermohonan) {
    //        // Pastikan setiap elemen memiliki data yang dibutuhkan
    //        if (isset($keyPermohonan['NAMA_TERMOHON'], $keyPermohonan['NIK_TERMOHON'], $keyPermohonan['JENIS_DOC'])) {
    //            $batchData[] = [
    //                'NAMA_TERMOHON'             => $keyPermohonan['NAMA_TERMOHON'], 
    //                'NIK_TERMOHON'              => $keyPermohonan['NIK_TERMOHON'],
    //                'JENIS_DOC'                 => $keyPermohonan['JENIS_DOC'],
    //            ];
    //        }

         
    //    }
        
		// echo json_encode(array("status" => TRUE,"alert" => 'success', "data"=>'No Pendaftaran: '.$no_pend.' Berhasil disimpan',"title" => 'Perhatian'));
	}
    
    public function simpan_cek_verifikasi_layanan() {

        // $termohon       = $this->request->getPost('NAMA_TERMOHON');
        // $niktermohon    = $this->request->getPost('NIK_TERMOHON');
        // $jenis_doc      = $this->request->getPost('JENIS_DOC');

        $dataRow = [
            'no_pend'               => $this->request->getPost('NO_PEND'),
            'kd_lokasi'             => $this->request->getPost('LOKASI_PENGAMBILAN'),
            'lokasi_pengambilan'    => lokasi_pengambilan($this->request->getPost('LOKASI_PENGAMBILAN')),
            'cat'                   => $this->request->getPost('CATATAN'),
        ];   

        $formData = $this->request->getPost('vrf');
        // $nm_lokasi =$this->request->getPost('LOKASI_PENGAMBILAN');
        // dd($formData);

		// $dt      = $this->input->post('detail');
		// $cat     = $this->input->post('master');
		// $no_pend = $this->input->post('no_pend');
		// $telp = $this->input->post('no_hp');
		// $kd_lokasi = $this->input->post('kd_pengambilan');
        // $nm_lokasi = $this->input->post('nm_pengambilan');
    
		// if($kd_lokasi != '')
        // {
		// $dt_master = array('FLAG_STATUS'=>1,'CATATAN' => $cat,'KD_PENGAMBILAN' => $kd_lokasi,'LOKASI_PENGAMBILAN' => $nm_lokasi);
        // }
    	// else
        // {
        // $dt_master = array('FLAG_STATUS'=>1,'CATATAN' => $cat);
        // }
		// $this->db->where('NO_PEND', $no_pend);
		// $this->db->update('PERMOHONAN_PELAYANAN_V2', $dt_master);
        $multipartData = [];

        // print_r($multipartData).exit();

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
                    // 'no_pend' => $data['no_pend'],
                    // 'status' => $data['status'],
                    'status' => 1,
                    'keterangan' => $data['ket'],
                    'no_urut' => $data['no_urut'],
                ];

                // dd($updateData);
    
                // Perbarui berdasarkan no_urut
                // $vrfModel->update($data['no_urut'], $updateData);
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

        // echo json_encode($multipartData);
        // echo "<pre>";
        // print_r($multipartData).exit();
        // echo "</pre>";

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
                // $this->session->destroy();
                // $sessions = $this->session->get();
                // Mencetak semua data sesi
                // echo '<pre>';
                // print_r($sessions);
                // echo '</pre>';
                // $this->session->remove(['NIK', 'NAMA_PEMOHON','ALAMAT','NO_HP','EMAIL_TERMOHON','TGL_RENCANA_PENGAMBILAN','LOKASI_PENGAMBILAN','CATATAN','permohonan']);
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

    //     $batchData = [];
    //     foreach ($detailPermohonan as $keyPermohonan) {
    //        // Pastikan setiap elemen memiliki data yang dibutuhkan
    //        if (isset($keyPermohonan['NAMA_TERMOHON'], $keyPermohonan['NIK_TERMOHON'], $keyPermohonan['JENIS_DOC'])) {
    //            $batchData[] = [
    //                'NAMA_TERMOHON'             => $keyPermohonan['NAMA_TERMOHON'], 
    //                'NIK_TERMOHON'              => $keyPermohonan['NIK_TERMOHON'],
    //                'JENIS_DOC'                 => $keyPermohonan['JENIS_DOC'],
    //            ];
    //        }

         
    //    }
        
		// echo json_encode(array("status" => TRUE,"alert" => 'success', "data"=>'No Pendaftaran: '.$no_pend.' Berhasil disimpan',"title" => 'Perhatian'));
	}

    public function index()
    {
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'kategori';
        return view('pelayanandukcapil/layanan/index', $data);
    }

    public function new()
    {

        $data['kategoris'] = $this->kategori->findAll(); // Fetch all kategori items for the parent dropdown

        return view('kategori/new', $data);
    }

    public function show($id)
    {
        // Fetch category by ID
        $data['kategori'] = $this->kategori->find($id);

        // Check if category exists
        if (!$data['kategori']) {
            throw new PageNotFoundException('Kategori not found');
        }

        // Set up pagination
        $pager = \Config\Services::pager();
        $perPage = 10; // Number of articles per page
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;

        // Fetch articles related to the category with pagination
        $data['articles'] = $this->artikel->where('id_kategori', $id)
            ->paginate($perPage, 'articles', $page);

        // Pass pagination data to the view
        $data['pager'] = $this->artikel->pager;

        // Pass data to the view
        return view('kategori/show', $data);
    }

    public function edit($id)
    {
        $data['kategori'] = $this->kategori->find($id);
        $data['kategoris'] = $this->kategori->findAll();
        if (!$data['kategori']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('kategori not found');
        }
        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        if ($this->validate([
            'kategori' => 'required|string|max_length[100]',
            'tipe' => 'required|integer',
            'urut' => 'required|integer',
            'enabled' => 'required|integer',
        ])) {
            $this->kategori->update($id, $data);
            return redirect()->to('/admin/kategori')->with('message', 'kategori updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        try {
            $this->kategori->delete($id);
            return redirect()->to('/admin/kategori')->with('message', 'kategori deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting kategori: ' . $e->getMessage());
        }
    }

    public function cetak1() {
		// $this->load->helper('file');
		// $this->load->helper(array('My_pdf'));
		set_time_limit(0);
		ini_set('memory_limit', -1);
		// $this->load->model('pendaftaranmodel');

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

        // $html       		= view('pelayanandukcapil/layanan/pdf_template', $data);
        $html       		= view('pelayanandukcapil/layanan/pdf_master', $data);
		$html 				.= "<pagebreak />";
		$html 				.= view('pelayanandukcapil/layanan/pdf_detail', $data); 


        // dd($html);
        // Konfigurasi Dompdf
        $options = new Options();
        // $options->set('isRemoteEnabled', true); // Untuk mengizinkan akses gambar eksternal
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output file PDF ke browser
        $dompdf->stream('contoh.pdf', ['Attachment' => false]);
		
	}


    public function cetakx()
    {
        // Inisialisasi library mPDF
        $pdf = new Pdf();

        // Data untuk template
        set_time_limit(0);
		ini_set('memory_limit', -1);
		// $this->load->model('pendaftaranmodel');

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

        // $html       		= view('pelayanandukcapil/layanan/pdf_template', $data);
        $html       		= view('pelayanandukcapil/layanan/pdf_master', $data);
		$html 				.= "<pagebreak />";
		$html 				.= view('pelayanandukcapil/layanan/pdf_detail', $data); 


        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'orientation' => 'P', // Portrait
            'tempDir' => FCPATH . 'writable/temp' // Pastikan folder writable/temp ada
        ]);
        
       // Load HTML ke mPDF
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output('contoh.pdf', \Mpdf\Output\Destination::INLINE); // Tampilkan di browser
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

        // $html       		= view('pelayanandukcapil/layanan/pdf_template', $data);
        $html  = view('pelayanandukcapil/layanan/pdf_master', $data);
		$html .= "<pagebreak />";
		$html .= view('pelayanandukcapil/layanan/pdf_detail', $data); 	
        // $html .= "<pagebreak />";
		// $html .= view('pelayanandukcapil/layanan/pdf_detail2', $data); 
        // end

        // $pdf->setOptions([
        //     'margin_top' => 20,
        //     'margin_bottom' => 20,
        // ]);
        
        // $mpdf = $pdf->getInstance();
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output('arjun.pdf','I');
        // $mpdf->Output($file_name . '.pdf', 'I');
    }
}
