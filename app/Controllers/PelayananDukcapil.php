<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use GuzzleHttp\Client;

class PelayananDukcapil extends BaseController
{
    protected $kategori;
    protected $artikel;
    protected $session;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
        $this->artikel = new ArtikelModel();
        $this->session = session(); // Memulai session
    }


    // new
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

        // dd($data);
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';
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

        $data['permohonanData'] = $this->session->get('permohonan');
        // dd($permohonanData);
        // echo"<pre>";
        // print_r($permohonanData).exit();
        // echo"</pre>";

        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';
        return view('pelayanandukcapil/layanan/v_verifikasi_detail_permohonan', $data);
    }
    
    public function verifikasi_upload_dokumen()
    {
       
        // Ambil data dari form
        $termohon       = $this->request->getPost('NAMA_TERMOHON');
        $niktermohon    = $this->request->getPost('NIK_TERMOHON');
        $jenis_doc      = $this->request->getPost('JENIS_DOC');

        // $data = [
        //     'termohon'       => $this->request->getPost('NAMA_TERMOHON'),
        //     'niktermohon'    => $this->request->getPost('NIK_TERMOHON'),
        //     'jenis_doc'     => $this->request->getPost('JENIS_DOC'),
        // ];

        // dd($data);
        // Simpan data permohonan di session
        if ($termohon &&  $niktermohon && $jenis_doc) {
            $permohonanData = [];
            foreach ($termohon as $index => $value) {
                $permohonanData[] = [
                    'NAMA_TERMOHON' => $value,
                    'NIK_TERMOHON' => $niktermohon[$index],
                    'JENIS_DOC' => $jenis_doc[$index]
                ];


            }

        $this->session->set('permohonan', $permohonanData);

        // dd($permohonanData).exit();
        
        }

        $data = [
            'JENIS_DOC'             => $this->session->get('JENIS_DOC'),
            'LOKASI_PENGAMBILAN'    => $this->session->get('LOKASI_PENGAMBILAN'),
            'CATATAN'               => $this->session->get('CATATAN'),
        ];

        // dd($data);

        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'verifikasi-data';

        return view('pelayanandukcapil/layanan/v_verifikasi_upload_dokumen', $data);
    }
    
    public function simpan_permohonan()
    {
        // $lokasiPengambilan  = $this->request->getPost('LOKASI_PENGAMBILAN');
        // $catatan            = $this->request->getPost('CATATAN');

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

        // Ambil file dari request
        $pdfFiles = $this->request->getFiles();

        // Proses penyimpanan file pertama jika ada
        if (isset($pdfFiles['fileUpload1']) && $pdfFiles['fileUpload1']->isValid() && !$pdfFiles['fileUpload1']->hasMoved()) {
            $pdfFiles['fileUpload1']->move(WRITEPATH . 'uploads', $pdfFiles['fileUpload1']->getRandomName());
        }

        // Proses penyimpanan file kedua jika ada
        if (isset($pdfFiles['fileUpload2']) && $pdfFiles['fileUpload2']->isValid() && !$pdfFiles['fileUpload2']->hasMoved()) {
            $pdfFiles['fileUpload2']->move(WRITEPATH . 'uploads', $pdfFiles['fileUpload2']->getRandomName());
        }

        // Mengambil data lainnya dari session untuk disimpan atau diproses lebih lanjut
        // $name       = $this->session->get('name');
        // $address    = $this->session->get('address');
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'progres-pelayanan';

        return view('pelayanandukcapil/layanan/v_progres_pelayanan', $data);
    }    
    
    public function progres_pelayanan()
    {
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'progres-pelayanan';

        
        return view('pelayanandukcapil/layanan/v_progres_pelayanan', $data);
    }   
    
    public function siap_ambil()
    {
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'siap-ambil';
        return view('pelayanandukcapil/layanan/v_siap_ambil', $data);
    }    
    
    public function rekap_layanan()
    {
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'rekap-layanan';
        return view('pelayanandukcapil/layanan/v_rekap_layanan', $data);
    }
    // end new

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

    public function storeold()
    {
        // Validation rules
        $validationRules = [
            'kategori' => 'required|string|max_length[100]',
            'tipe' => 'required|integer',
            'urut' => 'required|integer',
            'enabled' => 'required|integer',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kategori' => $this->request->getVar('kategori'),
            'tipe' => $this->request->getVar('tipe'),
            'urut' => $this->request->getVar('urut'),
            'enabled' => $this->request->getVar('enabled'),
            'parrent' => $this->request->getVar('parrent'),
        ];

        // Save the data using the model
        if ($this->kategori->save($data)) {
            return redirect()->to('/admin/kategori')->with('message', 'Kategori added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->kategori->errors());
        }
    }


    // berhasil upload file dari client ke api server
    public function store1()
    {
        $filePath = 'uploads/1730424303_9f7fd296845be8dcca57.jpg'; // Path file yang ingin diupload
        
        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File not found.'
            ]);
        }
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://dev-smart.gunungkidulkab.go.id/api/upload"); // Ganti dengan URL API server Anda
        curl_setopt($ch, CURLOPT_POST, 1);

        // Tambahkan file ke POST request
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new \CURLFile($filePath)
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $this->response->setJSON(json_decode($response, true));
    }

    public function storeBerhasil()
    {
        $client = new Client();

        // Data tambahan dari form
        $data = [
            [
                'name'     => 'NAMA_TERMOHON',
                'contents' => $this->request->getPost('NAMA_TERMOHON')
            ]
        ];

        // Mengambil file dari input form
        $file = $this->request->getFile('FILE_URL');

        // Periksa apakah file valid
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File not found or invalid.'
            ]);
        }

        // Tambahkan file ke multipart
        $fileData = [
            'name'     => 'FILE_URL',
            'contents' => fopen($file->getTempName(), 'r'),
            'filename' => $file->getName()
        ];

        // Gabungkan data dan file dalam satu array `multipart`
        $multipartData = array_merge($data, [$fileData]);

        // Kirim permintaan POST ke API server
        $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/upload', [
            'multipart' => $multipartData
        ]);

        // Mengembalikan respons dari API server
        return $this->response->setJSON(json_decode($response->getBody(), true));
    }

    public function store()
    {
        $client = new Client();

        // Data tambahan dari form
        $data = [
            'NIK'               => $this->request->getPost('NIK'),
            'NAMA_TERMOHON'     => $this->request->getPost('NAMA_TERMOHON'),
            'ALAMAT_PEMOHON'    => $this->request->getPost('ALAMAT_PEMOHON'),
            'KET'               => $this->request->getPost('KET'),
            'CONTACT_PEMOHON'   => $this->request->getPost('CONTACT_PEMOHON'),
            'CATATAN'           => $this->request->getPost('CATATAN'),
            'EMAIL'             => $this->request->getPost('EMAIL'),
        ];

        // Mengambil file dari input form
        $file = $this->request->getFile('FILE_URL');

        // Periksa apakah file valid
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File not found or invalid.'
            ]);
        }

        // Buat array `multipart` untuk Guzzle
        $multipartData = [];

        // Tambahkan setiap item data ke dalam array `multipart`
        foreach ($data as $name => $contents) {
            $multipartData[] = [
                'name'     => $name,
                'contents' => $contents
            ];
        }

        // Tambahkan file ke dalam array `multipart`
        $multipartData[] = [
            'name'     => 'FILE_URL',
            'contents' => fopen($file->getTempName(), 'r'),
            'filename' => $file->getName()
        ];

        // Kirim permintaan POST ke API server
        $response = $client->post('https://dev-smart.gunungkidulkab.go.id/api/upload', [
            'multipart' => $multipartData
        ]);

        // Mengembalikan respons dari API server
        return $this->response->setJSON(json_decode($response->getBody(), true));
    }
    
    public function storee()
    {
        // Inisialisasi CURL request
        // $client = \Config\Services::curlrequest();

        $http = Services::curlrequest();

        // Validation rules
        $validationRules = [
            'NAMA_TERMOHON' => 'required',
            'FILE_URL' => 'uploaded[FILE_URL]|max_size[FILE_URL,3024]|is_image[FILE_URL]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('FILE_URL');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/', $fileName);
            
            $data = [
                'NAMA_TERMOHON' => $this->request->getPost('NAMA_TERMOHON'),
                'FILE_URL' => $fileName,
            ];

            // print_r($data).exit();
        }

        $url        = 'https://dev-smart.gunungkidulkab.go.id/ApiController';
        $response = $http->request('POST', $url, ['multipart' => $data, 'http_errors' => false]);

        // Tampilkan response
        echo $response->getBody();
    }

    public function upload()
    {
        // Validasi apakah file ada dalam request
        if ($this->request->getFile('file')->isValid()) {
            try {
                $file = $this->request->getFile('file');

                // print_r($file).exit();
                $fileName = $file->getRandomName();
                // print_r($fileName).exit();

                // Pindahkan file ke folder 'uploads'
                $file->move('uploads/', $fileName);

                // Path file yang baru di folder 'uploads'
                $filePath = 'uploads/' . $fileName;
                // print_r($filePath).exit();

                // Pastikan file berhasil disimpan di lokasi tersebut
                if (!file_exists($filePath)) {
                    return 'File not found in uploads directory!';
                }

                // print_r($file).exit();
                // $fileName = $file->getName(); // Dapatkan nama file asli

                // Buat form params
                // $params = [
                //     'file' => curl_file_create($file->getTempName(), $file->getMimeType(), $fileName)
                // ];

                // print_r($params).exit();
                // print_r($fileName).exit();
                // Inisialisasi CURL
                $client = \Config\Services::curlrequest();

                // URL API server tempat file akan diupload
                $url = "https://dev-smart.gunungkidulkab.go.id/api/upload"; // Sesuaikan dengan API server

                // Kirim request POST ke API server
                $response = $client->post($url, [
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' =>  fopen($filePath, 'r'),
                            'filename' => $fileName
                        ],
                    ],
                ]);

                // print_r($response).exit();
                
                 // Cek status respons dari API server
                if ($response->getStatusCode() === 201) {
                    return 'File successfully uploaded to API server!';
                } else {
                    return 'Failed to upload file. API response: ' . $response->getBody();
                }
            } catch (\Exception $e) {
                return 'Error: ' . $e->getMessage();
            }
        } else {
            return 'No file uploaded or invalid file!';
        }
    }

    public function push() {
        // Load HTTPClient
        
        $http = Services::curlrequest();
        $db = \Config\Database::connect();

    
        $url = 'https://dev-smart.gunungkidulkab.go.id/api/createlayanan';
        $headers = [];
        

        // Data yang akan dikirimkan
        $data = [
            'NAMA_TERMOHON' => $this->request->getPost('NAMA_TERMOHON'),
            // 'FILE_URL' => $this->request->getPost('FILE_URL'),

        ];

        // print_r($data).exit();

        // Convert array to JSON
        $jsonData = json_encode($data);
        // print_r($data).exit();

        // print_r($data);

        // Username dan Password untuk Basic Auth
        // $username = 'kabgunungkidul';
        // $password = 'hqQBBO0uLXDoHzkVvhCWe18cQo1wBIFX';

        // Encode username dan password dalam format Base64
        // $credentials = base64_encode("$username:$password");
        
        // Header Authorization dan Content-Type
        // $http->setHeader('Authorization', 'Basic ' . $credentials);
        $http->setHeader('Content-Type', 'application/json');

        $response = $http->request('POST', $url, ['form_params' => $data, 'headers' => $headers, 'http_errors' => false]);


        // Tampilkan response
        echo $response->getBody();

        
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
}
