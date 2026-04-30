<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAnggaranModel extends Model
{
    protected $table = 'tahun_anggaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tahun', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
