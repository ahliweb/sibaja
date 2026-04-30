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
    ];
}
