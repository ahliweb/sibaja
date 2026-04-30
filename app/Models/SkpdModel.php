<?php

namespace App\Models;

use CodeIgniter\Model;

class SkpdModel extends Model
{
    protected $table = 'skpd';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['kode_skpd', 'nama_skpd', 'kepala_skpd', 'nip_kepala', 'alamat', 'kontak', 'email', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kode_skpd' => 'required|max_length[20]|is_unique[skpd.kode_skpd,id,{id}]',
        'nama_skpd' => 'required|max_length[200]',
    ];

    protected $validationMessages = [
        'kode_skpd' => [
            'required'   => 'Kode SKPD wajib diisi.',
            'max_length' => 'Kode SKPD maksimal 20 karakter.',
            'is_unique'  => 'Kode SKPD sudah digunakan.',
        ],
        'nama_skpd' => [
            'required'   => 'Nama SKPD wajib diisi.',
            'max_length' => 'Nama SKPD maksimal 200 karakter.',
        ],
    ];
}
