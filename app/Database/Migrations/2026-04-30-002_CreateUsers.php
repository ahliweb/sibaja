<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'username'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'password'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'          => ['type' => 'ENUM', 'constraint' => ['admin', 'petugas', 'skpd'], 'default' => 'skpd'],
            'skpd_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'last_login'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->addForeignKey('skpd_id', 'skpd', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
