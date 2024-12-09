<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table      = 'komentar';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_artikel',
        'owner',
        'email',
        'komentar',
        'tgl_upload',
        'enabled'
    ];

    public function getcomments($limit = null, $desa_id = null)
    {
        $builder = $this->select('komentar.*, artikel.judul as article_title')
            ->where('komentar.enabled', 1)
            ->where('desa_id', $desa_id)
            ->join('artikel', 'komentar.id_artikel = artikel.id', 'left');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }
}
