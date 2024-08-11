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

        // Set validation rules
        $validation->setRules([
            'satuan' => [
                'rules' => 'uploaded[satuan]'
                    . '|ext_in[satuan,pdf,doc,docx,xls,xlsx,ppt,pptx,txt]'
                    . '|mime_in[satuan,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain]'
                    . '|max_size[satuan,50000]', // 50 MB limit
                'errors' => [
                    'uploaded' => 'No document uploaded.',
                    'ext_in' => 'The file extension must be one of: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
                    'mime_in' => 'The file type must be a valid document format (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT).',
                    'max_size' => 'The document size must be less than 50 MB.'
                ]
            ],
        ]);

        if ($document && !$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $documentpath = null; // Default value in case no document is uploaded

        if ($document && $document->isValid()) {
            $random_id = (new \DateTime())->format('YmdHis');
            $uploadPath = 'uploads/document/' . $random_id;

            // Create directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the main document
            $newName = $document->getName(); // getName() returns the original name
            $document->move($uploadPath, $newName);
            $documentpath = $uploadPath . '/' . $newName;
        }

        // Save document data to the model
        $this->dokumenModel->save([
            'satuan' => $documentpath,
            'nama' => $this->request->getPost('nama'),
            'enabled' => $this->request->getPost('enabled'),
            'tgl_upload' => $this->request->getPost('tgl_upload'),
            'id_pend' => 1,
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

        // Retrieve existing document data
        $existingDocument = $this->dokumenModel->find($id);
        if (!$existingDocument) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Set validation rules for the uploaded document if any
        if ($document && $document->isValid()) {
            $validation->setRules([
                'satuan' => [
                    'rules' => 'uploaded[satuan]'
                        . '|ext_in[satuan,pdf,doc,docx,xls,xlsx,ppt,pptx,txt]'
                        . '|mime_in[satuan,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain]'
                        . '|max_size[satuan,50000]', // 50 MB limit
                    'errors' => [
                        'uploaded' => 'No document uploaded.',
                        'ext_in' => 'The file extension must be one of: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
                        'mime_in' => 'The file type must be a valid document format (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT).',
                        'max_size' => 'The document size must be less than 50 MB.'
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

            // Sanitize file name by replacing spaces with underscores
            $fileName = $document->getName();
            $sanitizedFileName = str_replace(' ', '_', $fileName);

            // Move the document to the new location with sanitized name
            $document->move($uploadPath, $sanitizedFileName);
            $documentpath = $uploadPath . '/' . $sanitizedFileName;

            // Optionally, delete the old document file if it exists
            if (!empty($existingDocument['satuan']) && file_exists($existingDocument['satuan'])) {
                unlink($existingDocument['satuan']);
            }
        } else {
            // No new file uploaded, retain the existing file path
            $documentpath = $existingDocument['satuan'];
        }

        // Prepare data for update
        $data = [
            'satuan' => $documentpath,
            'nama' => $this->request->getPost('nama'),
            'enabled' => $this->request->getPost('enabled'),
            'tgl_upload' => $this->request->getPost('tgl_upload'),
            'id_pend' => 1,
        ];

        // Update the document data
        if ($this->dokumenModel->update($id, $data)) {
            return redirect()->to('/admin/dokumen')->with('message', 'Dokumen updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->dokumenModel->errors());
        }
    }





    public function delete($id)
    {
        $this->dokumenModel->delete($id);
        return redirect()->to('/admin/dokumen');
    }
}
