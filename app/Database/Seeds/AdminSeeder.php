<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Default admin user
        $this->db->table('users')->insert([
            'nama'      => 'Administrator',
            'username'  => 'admin',
            'email'     => 'admin@kobar.go.id',
            'password'  => password_hash('password', PASSWORD_DEFAULT),
            'role'      => 'admin',
            'skpd_id'   => null,
            'status'    => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Sample SKPD
        $skpd = [
            ['kode_skpd' => 'SKPD-01', 'nama_skpd' => 'Dinas Pendidikan', 'kepala_skpd' => 'Dr. Ahmad Fauzi, M.Pd', 'nip_kepala' => '197501012006041001', 'alamat' => 'Jl. Pendidikan No. 1', 'kontak' => '0812-3456-7890', 'email' => 'disdik@kobar.go.id'],
            ['kode_skpd' => 'SKPD-02', 'nama_skpd' => 'Dinas Kesehatan', 'kepala_skpd' => 'dr. Siti Rahayu', 'nip_kepala' => '198003152008012002', 'alamat' => 'Jl. Sehat No. 2', 'kontak' => '0812-3456-7891', 'email' => 'dinkes@kobar.go.id'],
            ['kode_skpd' => 'SKPD-03', 'nama_skpd' => 'Dinas PUPR', 'kepala_skpd' => 'Ir. Budi Santoso, MT', 'nip_kepala' => '197802102006041003', 'alamat' => 'Jl. Pembangunan No. 3', 'kontak' => '0812-3456-7892', 'email' => 'pupr@kobar.go.id'],
        ];

        foreach ($skpd as $s) {
            $s['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('skpd')->insert($s);
        }

        // Sample SKPD user
        $this->db->table('users')->insert([
            'nama'      => 'Joko Operator',
            'username'  => 'disdik',
            'email'     => 'disdik.operator@kobar.go.id',
            'password'  => password_hash('password', PASSWORD_DEFAULT),
            'role'      => 'skpd',
            'skpd_id'   => 1,
            'status'    => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Sample Petugas
        $this->db->table('users')->insert([
            'nama'      => 'Ani Verifikator',
            'username'  => 'petugas',
            'email'     => 'petugas@kobar.go.id',
            'password'  => password_hash('password', PASSWORD_DEFAULT),
            'role'      => 'petugas',
            'skpd_id'   => null,
            'status'    => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Jenis Pengadaan
        $jenis = [
            ['nama' => 'Barang', 'deskripsi' => 'Pengadaan barang (ATK, peralatan, dsb)'],
            ['nama' => 'Jasa Konsultansi', 'deskripsi' => 'Pengadaan jasa konsultansi'],
            ['nama' => 'Pekerjaan Konstruksi', 'deskripsi' => 'Pengadaan pekerjaan konstruksi'],
            ['nama' => 'Jasa Lainnya', 'deskripsi' => 'Pengadaan jasa lainnya'],
        ];
        foreach ($jenis as $j) {
            $j['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('jenis_pengadaan')->insert($j);
        }

        // Metode Pengadaan
        $metode = [
            ['nama' => 'E-Purchasing', 'deskripsi' => 'Pembelian melalui e-katalog'],
            ['nama' => 'Pengadaan Langsung', 'deskripsi' => 'Pengadaan langsung dengan nilai tertentu'],
            ['nama' => 'Penunjukan Langsung', 'deskripsi' => 'Penunjukan langsung penyedia'],
            ['nama' => 'Tender/Seleksi', 'deskripsi' => 'Tender/seleksi terbuka'],
        ];
        foreach ($metode as $m) {
            $m['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('metode_pengadaan')->insert($m);
        }

        // Tahun Anggaran
        for ($t = 2024; $t <= 2026; $t++) {
            $this->db->table('tahun_anggaran')->insert([
                'tahun'      => $t,
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
