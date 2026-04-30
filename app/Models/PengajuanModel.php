<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nomor_pengajuan', 'tanggal', 'skpd_id', 'user_id', 'nama_paket',
        'jenis_id', 'metode_id', 'pagu_anggaran', 'sumber_dana', 'lokasi',
        'uraian', 'spesifikasi', 'status', 'tahun_anggaran_id',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
