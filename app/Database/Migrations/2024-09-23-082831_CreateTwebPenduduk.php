<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukTable extends Migration
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
                'constraint' => 100,
                'null'       => true,
            ],
            'nik' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_kk' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'kk_level' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_rtm' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'rtm_level' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'sex' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'tempatlahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tanggallahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'agama_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'pendidikan_kk_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'pendidikan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'pendidikan_sedang_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'pekerjaan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'status_kawin' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'warganegara_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'dokumen_pasport' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'dokumen_kitas' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'ayah_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
            ],
            'ibu_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
            ],
            'nama_ayah' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'nama_ibu' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'golongan_darah_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'id_cluster' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'alamat_sebelumnya' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'alamat_sekarang' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'status_dasar' => [
                'type'       => 'TINYINT',
                'null'       => true,
            ],
            'hamil' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'cacat_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'sakit_menahun_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'jamkesmas' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'akta_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],
            'akta_perkawinan' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],
            'tanggalperkawinan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'akta_perceraian' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],
            'tanggalperceraian' => [
                'type' => 'DATE',
                'null' => true,
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
        $this->forge->createTable('tweb_penduduk');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk');
    }
}
