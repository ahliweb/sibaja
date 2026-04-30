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

    protected $validationRules = [
        'nama_paket'        => 'required|max_length[300]',
        'jenis_id'          => 'required|integer',
        'metode_id'         => 'required|integer',
        'pagu_anggaran'     => 'required|numeric',
        'sumber_dana'       => 'required|max_length[100]',
        'uraian'            => 'required',
        'tahun_anggaran_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nama_paket' => [
            'required'   => 'Nama paket wajib diisi.',
            'max_length' => 'Nama paket maksimal 300 karakter.',
        ],
        'pagu_anggaran' => [
            'required' => 'Pagu anggaran wajib diisi.',
            'numeric'  => 'Pagu anggaran harus berupa angka.',
        ],
        'sumber_dana' => [
            'required' => 'Sumber dana wajib diisi.',
        ],
        'uraian' => [
            'required' => 'Uraian kebutuhan wajib diisi.',
        ],
        'tahun_anggaran_id' => [
            'required' => 'Tahun anggaran wajib dipilih.',
        ],
    ];

    public function getWithRelations(?int $perPage = null)
    {
        $this->select('pengajuan.*, skpd.nama_skpd, jenis_pengadaan.nama as jenis_nama, metode_pengadaan.nama as metode_nama, tahun_anggaran.tahun')
             ->join('skpd', 'skpd.id = pengajuan.skpd_id', 'left')
             ->join('jenis_pengadaan', 'jenis_pengadaan.id = pengajuan.jenis_id', 'left')
             ->join('metode_pengadaan', 'metode_pengadaan.id = pengajuan.metode_id', 'left')
             ->join('tahun_anggaran', 'tahun_anggaran.id = pengajuan.tahun_anggaran_id', 'left')
             ->orderBy('pengajuan.created_at', 'DESC');

        if ($perPage) {
            return [
                'pengajuan' => $this->paginate($perPage),
                'pager'     => $this->pager,
            ];
        }

        return $this->findAll();
    }
}
