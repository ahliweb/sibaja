<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'role'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'modul'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'aksi'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi'     => ['type' => 'TEXT', 'null' => true],
            'ip_address'    => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent'    => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('created_at');
        $this->forge->addKey('user_id');
        $this->forge->createTable('audit_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('audit_log', true);
    }
}
