<?php

use CodeIgniter\Database\Migration;

class CreateTwebWilClusterdesaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'rt' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,  // Allow NULL
            ],
            'rw' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,  // Allow NULL
            ],
            'dusun' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,  // Allow NULL
            ],
            'id_kepala' => [
                'type' => 'BIGINT',
            ],
            'lat' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,  // Allow NULL
            ],
            'lng' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,  // Allow NULL
            ],
            'zoom' => [
                'type' => 'INT',
                'null' => true,  // Allow NULL
            ],
            'path' => [
                'type' => 'TEXT',
                'null' => true,  // Allow NULL
            ],
            'map_tipe' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,  // Allow NULL
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_wil_clusterdesa');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_wil_clusterdesa');
    }
}
