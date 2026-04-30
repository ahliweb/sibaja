<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengajuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nomor_pengajuan'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'tanggal'           => ['type' => 'DATE'],
            'skpd_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_paket'        => ['type' => 'VARCHAR', 'constraint' => 300],
            'jenis_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'metode_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'pagu_anggaran'     => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'sumber_dana'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'lokasi'            => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'uraian'            => ['type' => 'TEXT'],
            'spesifikasi'       => ['type' => 'TEXT', 'null' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['draft', 'diajukan', 'diverifikasi', 'dalam_proses', 'selesai', 'perlu_perbaikan', 'ditolak'], 'default' => 'draft'],
            'tahun_anggaran_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nomor_pengajuan');
        $this->forge->addForeignKey('skpd_id', 'skpd', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jenis_id', 'jenis_pengadaan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('metode_id', 'metode_pengadaan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tahun_anggaran_id', 'tahun_anggaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan', true);
    }
}
