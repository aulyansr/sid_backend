<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaSosialModel extends Model
{
    protected $table      = 'media_sosial';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['gambar', 'link', 'nama', 'enabled'];

    protected $useTimestamps = false;
}
