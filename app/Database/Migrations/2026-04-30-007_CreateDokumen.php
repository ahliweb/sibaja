<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pengajuan_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_dokumen'     => ['type' => 'VARCHAR', 'constraint' => 200],
            'nama_file'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama_asli'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'ukuran'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status_verifikasi' => ['type' => 'ENUM', 'constraint' => ['belum_diperiksa', 'lengkap', 'perlu_perbaikan', 'ditolak'], 'default' => 'belum_diperiksa'],
            'catatan'           => ['type' => 'TEXT', 'null' => true],
            'uploaded_at'       => ['type' => 'DATETIME', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pengajuan_id', 'pengajuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dokumen', true);
    }

    public function down()
    {
        $this->forge->dropTable('dokumen', true);
    }
}
