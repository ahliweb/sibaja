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
    protected $updatedField = false;
}
