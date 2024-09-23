<?php

namespace App\Controllers;

use App\Models\ClusterDesaModel;

class ClusterDesa extends BaseController
{
    protected $clusterModel;

    public function __construct()
    {
        $this->clusterModel = new ClusterDesaModel();
    }

    public function index()
    {

        $data['clusters'] = $this->clusterModel->getClustersWithPamong()->where('parent IS NULL')->findAll();
        $data['activeTab'] = 'wilayah';

        return view('cluster_desa/index', $data);
    }

    public function new()
    {
        return view('cluster_desa/create');
    }

    public function new_rw($id)
    {
        $data['cluster'] = $this->clusterModel->find($id);
        return view('cluster_desa/add_rw', $data);
    }

    public function new_rt($id)
    {
        $data['cluster'] = $this->clusterModel->find($id);
        return view('cluster_desa/add_rt', $data);
    }

    public function create()
    {
        $this->clusterModel->save($this->request->getPost());
        return redirect()->to('/admin/wilayah');
    }

    public function show($id)
    {
        // Fetch the specific cluster by its ID
        $data['cluster'] = $this->clusterModel->find($id);

        // Check if the cluster exists
        if (!$data['cluster']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cluster not found.');
        }

        // Fetch all clusters that belong to the same 'dusun' with 'Pamong' relation
        $data['clusters'] = $this->clusterModel->getClustersWithPamong()
            ->where('parent', $data['cluster']['id'])
            ->findAll();

        // Set active tab
        $data['activeTab'] = 'wilayah';

        // Load the view with the data
        return view('cluster_desa/show', $data);
    }



    public function edit($id)
    {
        $data['cluster'] = $this->clusterModel->find($id);
        return view('cluster_desa/edit', $data);
    }

    public function update($id)
    {
        $this->clusterModel->update($id, $this->request->getPost());
        return redirect()->to('/admin/wilayah');
    }

    public function delete($id)
    {
        $this->clusterModel->delete($id);
        return redirect()->to('/admin/wilayah');
    }

    public function index_rw($id)
    {
        // Fetch the specific cluster by its ID
        $data['cluster'] = $this->clusterModel->find($id);

        // Check if the cluster exists
        if (!$data['cluster']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cluster not found.');
        }

        // Fetch all clusters that belong to the same 'dusun' with 'Pamong' relation
        $data['clusters'] = $this->clusterModel->getClustersWithPamong()
            ->where('parent', $data['cluster']['id'])
            ->findAll();

        // Set active tab
        $data['activeTab'] = 'wilayah';

        // Load the view with the data
        return view('cluster_desa/index_rw', $data);
    }
}
