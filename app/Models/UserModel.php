<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'username', 'email', 'password', 'role', 'skpd_id', 'status', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama'     => 'required|min_length[3]|max_length[200]',
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[8]',
        'role'     => 'required|in_list[admin,petugas,skpd]',
        'email'    => 'permit_empty|valid_email|max_length[100]',
        'status'   => 'permit_empty|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 200 karakter.',
        ],
        'username' => [
            'required'   => 'Username wajib diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 50 karakter.',
            'is_unique'  => 'Username sudah digunakan.',
        ],
        'password' => [
            'required'   => 'Password wajib diisi.',
            'min_length' => 'Password minimal 8 karakter.',
        ],
        'role' => [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role tidak valid.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
        ],
    ];
}
