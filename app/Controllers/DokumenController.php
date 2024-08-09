<?php

namespace App\Controllers;

use App\Models\DokumenModel;
use CodeIgniter\Controller;

class DokumenController extends Controller
{
    protected $dokumenModel;

    public function __construct()
    {
        $this->dokumenModel = new DokumenModel();
    }

    public function index()
    {
        $data['dokumen'] = $this->dokumenModel->findAll();
        $data['activeTab'] = 'dokumen';
        return view('dokumen/index', $data);
    }

    public function new()
    {
        return view('dokumen/new');
    }

    public function store()
    {

        $document = $this->request->getFile('satuan');
        $validation = \Config\Services::validation();
        $documentpath = null;

        // Validate the uploaded document
        if ($document && $document->isValid()) {
            $validation->setRules([
                'dokumen' => [
                    'rules' => 'uploaded[satuan]'
                        . '|ext_in[satuan,pdf,doc,docx,xls,xlsx,ppt,pptx,txt]'
                        . '|mime_in[satuan,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain]'
                        . '|max_size[satuan,5000]', // 5000 KB (5 MB) limit
                    'errors' => [
                        'uploaded' => 'No document uploaded.',
                        'ext_in' => 'The file extension must be one of: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
                        'mime_in' => 'The file type must be a valid document format (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT).',
                        'max_size' => 'The document size must be less than 5 MB.'
                    ]
                ],
            ]);


            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $random_id =  (new \DateTime())->format('YmdHis');
            $uploadPath = 'uploads/document/' . $random_id;

            // Create directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the main document
            $newName = $document->getFilename();
            $document->move($uploadPath, $newName);
            $documentpath = $uploadPath . '/' . $newName;
        }
        $this->dokumenModel->save([
            'satuan' => $documentpath,
            'nama' => $this->request->getPost('nama'),
            'enabled' => $this->request->getPost('enabled'),
            'tgl_upload' => $this->request->getPost('tgl_upload'),
            'id_pend' => $this->request->getPost('id_pend'),
        ]);

        return redirect()->to('/admin/dokumen');
    }

    public function edit($id)
    {
        $data['dokumen'] = $this->dokumenModel->find($id);
        return view('dokumen/edit', $data);
    }

    public function update($id)
    {
        $document = $this->request->getFile('satuan');
        $validation = \Config\Services::validation();
        $documentpath = null;

        // Retrieve existing document data
        $existingDocument = $this->dokumenModel->find($id);
        if (!$existingDocument) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Validate the uploaded document if there is a new upload
        if ($document && $document->isValid()) {
            $validation->setRules([
                'satuan' => [
                    'rules' => 'uploaded[satuan]'
                        . '|ext_in[satuan,pdf,doc,docx,xls,xlsx,ppt,pptx,txt]'
                        . '|mime_in[satuan,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain]'
                        . '|max_size[satuan,5000]', // 5000 KB (5 MB) limit
                    'errors' => [
                        'uploaded' => 'No document uploaded.',
                        'ext_in' => 'The file extension must be one of: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
                        'mime_in' => 'The file type must be a valid document format (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT).',
                        'max_size' => 'The document size must be less than 5 MB.'
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $uploadPath = 'uploads/document/' . $id;

            // Create directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $document->getRandomName();
            $document->move($uploadPath, $newName);
            $documentpath = $uploadPath . '/' . $newName;

            // Optionally, delete the old document file if necessary
            if (!empty($existingDocument['satuan']) && file_exists($existingDocument['satuan'])) {
                unlink($existingDocument['satuan']);
            }
        } else {
            // No new file uploaded, retain the existing file path
            $documentpath = $existingDocument['satuan'];
        }

        // Update document data in the database
        $data = [
            'satuan' => $documentpath,
            'nama' => $this->request->getPost('nama'),
            'enabled' => $this->request->getPost('enabled'),
            'tgl_upload' => $this->request->getPost('tgl_upload'),
            'id_pend' => $this->request->getPost('id_pend'),
        ];

        if ($this->dokumenModel->update($id, $data)) {
            return redirect()->to('/admin/dokumen')->with('message', 'Dokumen updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->dokumenModel->errors());
        }
    }



    public function delete($id)
    {
        $this->dokumenModel->delete($id);
        return redirect()->to('/dokumen');
    }
}
