<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddUserAttributes extends Migration
{
    /**
     * @var string[]
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'id_grup' => [
                'type' => 'INT',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'company' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'session' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],

        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'full_name');
    }
}
