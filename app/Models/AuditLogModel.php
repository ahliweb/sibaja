<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'role', 'modul', 'aksi', 'deskripsi', 'ip_address', 'user_agent'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    protected $validationRules = [
        'modul' => 'required|max_length[50]',
        'aksi'  => 'required|max_length[50]',
    ];

    protected $validationMessages = [
        'modul' => ['required' => 'Modul wajib diisi.'],
        'aksi'  => ['required' => 'Aksi wajib diisi.'],
    ];

    public function getWithUser(?int $limit = 500)
    {
        $this->select('audit_log.*, users.nama as nama_user')
             ->join('users', 'users.id = audit_log.user_id', 'left')
             ->orderBy('audit_log.created_at', 'DESC');

        return $limit ? $this->findAll($limit) : $this->findAll();
    }
}
