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

    protected $validationRules = [
        'tahun' => 'required|integer|is_unique[tahun_anggaran.tahun]|greater_than[2000]|less_than[2100]',
    ];

    protected $validationMessages = [
        'tahun' => [
            'required'      => 'Tahun wajib diisi.',
            'integer'       => 'Tahun harus berupa angka.',
            'is_unique'     => 'Tahun anggaran sudah ada.',
            'greater_than'  => 'Tahun minimal 2000.',
            'less_than'     => 'Tahun maksimal 2099.',
        ],
    ];
}
