<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukLamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100
            ],
            'nik' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'id_kk' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'kk_level' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
            ],
            'id_rtm' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
            ],
            'rtm_level' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'sex' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
            ],
            'tempatlahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggallahir' => [
                'type' => 'DATE',
            ],
            'agama_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'pendidikan_kk_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'pendidikan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'pendidikan_sedang_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'pekerjaan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'status_kawin' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
            ],
            'warganegara_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'dokumen_pasport' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
            ],
            'dokumen_kitas' => [
                'type'       => 'INT',
            ],
            'ayah_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
            ],
            'ibu_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
            ],
            'nama_ayah' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_ibu' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'golongan_darah_id' => [
                'type'       => 'INT',
            ],
            'id_cluster' => [
                'type'       => 'INT',
            ],
            'status' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'alamat_sebelumnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'alamat_sekarang' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_dasar' => [
                'type'       => 'TINYINT',
            ],
            'hamil' => [
                'type'       => 'INT',
            ],
            'cacat_id' => [
                'type'       => 'INT',
            ],
            'sakit_menahun_id' => [
                'type'       => 'INT',
            ],
            'jamkesmas' => [
                'type'       => 'INT',
            ],
            'akta_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'akta_perkawinan' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'tanggalperkawinan' => [
                'type' => 'DATE',
            ],
            'akta_perceraian' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'tanggalperceraian' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_lama');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_lama');
    }
}
