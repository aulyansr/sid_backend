<?php

namespace App\Models;

use CodeIgniter\Model;

class TwebSuratFormatModel extends Model
{
    protected $table      = 'tweb_surat_format';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nama', 'url_surat', 'kode_surat', 'kunci', 'favorit'];

    protected $useTimestamps = false;
}
