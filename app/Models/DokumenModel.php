<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $table = 'dokumen';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'pengajuan_id', 'user_id', 'jenis_dokumen', 'nama_file',
        'nama_asli', 'ukuran', 'status_verifikasi', 'catatan',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'pengajuan_id'  => 'required|integer',
        'jenis_dokumen' => 'required|max_length[200]',
    ];

    protected $validationMessages = [
        'pengajuan_id'  => ['required' => 'Pengajuan wajib dipilih.'],
        'jenis_dokumen' => ['required' => 'Jenis dokumen wajib diisi.'],
    ];

    public function getWithPengajuan()
    {
        return $this->select('dokumen.*, pengajuan.nama_paket, pengajuan.nomor_pengajuan, skpd.nama_skpd')
                    ->join('pengajuan', 'pengajuan.id = dokumen.pengajuan_id', 'left')
                    ->join('skpd', 'skpd.id = pengajuan.skpd_id', 'left')
                    ->orderBy('dokumen.uploaded_at', 'DESC')
                    ->findAll();
    }
}
