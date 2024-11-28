<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisIndikatorModel extends Model
{
    protected $table = 'analisis_indikator';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_master',
        'nomor',
        'pertanyaan',
        'id_tipe',
        'bobot',
        'act_analisis',
        'id_kategori',
        'is_publik',
        'is_statistik',
        'is_required'
    ];

    protected $validationRules = [
        'id_master'    => 'required|integer',
        'nomor'        => 'required|numeric',
        'pertanyaan'   => 'required|string|max_length[255]',
        'id_tipe'      => 'required|integer',
        'bobot'        => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'act_analisis' => 'permit_empty|string|max_length[255]',
        'id_kategori'  => 'required|integer',
        'is_publik'    => 'required',
        'is_statistik' => 'required',
        'is_required'  => 'required',
    ];

    protected $useTimestamps = false;

    const multiple = 1;
    const checkbox = 2;
    const kuantitatif = 3;
    const teks = 4;
    const tanggal = 5;

    const ACTANALISIS_YA = 1;
    const ACTANALISIS_TIDAK = 2;

    const REQUIRED_YA = 1;
    const REQUIRED_TIDAK = 2;

    const PUBLICATION_YA = 1;
    const PUBLICATION_TIDAK = 2;

    public function getQuestionType()
    {
        return [
            self::multiple => 'Pilihan (Multiple Choice)',
            self::checkbox => 'Pilihan (Checkboxes)',
            self::kuantitatif => 'Isian Jumlah (Kuantitatif)',
            self::teks => 'Isian Teks (Kualitatif)',
            self::tanggal => 'Isian Tanggal',
        ];
    }

    public function getActAnalisisOptions()
    {
        return [
            self::ACTANALISIS_YA => 'Ya',
            self::ACTANALISIS_TIDAK => 'Tidak'
        ];
    }

    public function getRequiredOptions()
    {
        return [
            self::REQUIRED_YA => 'Ya',
            self::REQUIRED_TIDAK => 'Tidak'
        ];
    }

    public function getPublicationOptions()
    {
        return [
            self::PUBLICATION_YA => 'Ya',
            self::PUBLICATION_TIDAK => 'Tidak'
        ];
    }


    public function getBaseAttributes()
    {
        return $this->select([
            'analisis_indikator.*',

            'analisis_kategori_indikator.kategori AS kategori',
            'analisis_master.nama AS master',

        ])
            ->join('analisis_master', 'analisis_indikator.id_master = analisis_master.id', 'left')
            ->join('analisis_kategori_indikator', 'analisis_indikator.id_kategori = analisis_kategori_indikator.id', 'left');
    }
}
