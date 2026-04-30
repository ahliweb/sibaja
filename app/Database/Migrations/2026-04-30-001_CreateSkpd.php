<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSkpd extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_skpd'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama_skpd'     => ['type' => 'VARCHAR', 'constraint' => 200],
            'kepala_skpd'   => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'nip_kepala'    => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'alamat'        => ['type' => 'TEXT', 'null' => true],
            'kontak'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('kode_skpd');
        $this->forge->createTable('skpd', true);
    }

    public function down()
    {
        $this->forge->dropTable('skpd', true);
    }
}
