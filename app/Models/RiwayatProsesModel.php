<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatProsesModel extends Model
{
    protected $table = 'riwayat_proses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['pengajuan_id', 'user_id', 'status_sebelum', 'status_baru', 'catatan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
