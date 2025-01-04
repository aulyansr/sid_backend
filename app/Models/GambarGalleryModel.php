<?php

namespace App\Models;

use CodeIgniter\Model;

class GambarGalleryModel extends Model
{
    protected $table = 'gambar_gallery';
    protected $primaryKey = 'id';
    protected $allowedFields = ['parrent', 'gambar', 'nama', 'enabled', 'tgl_upload', 'tipe', 'desa_id'];

    protected $validationRules = [
        'parrent' => 'permit_empty|integer',
        'nama' => 'required|max_length[50]',
        'enabled' => 'required|integer|in_list[0,1]',
        'tgl_upload' => 'required',
        'tipe' => 'required|integer'
    ];

    public function getGalleriesByType($type)
    {
        return $this->where('tipe', $type)->findAll();
    }

    public function gallerySumary()
    {
        return $this->where('tipe', 0)->select('*, user.full_name AS user_name')
            ->join('user', 'user.id = gambar_gallery.user_id', 'left');
    }
}
