<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodePengadaanModel extends Model
{
    protected $table = 'metode_pengadaan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'deskripsi', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
