<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AuditClean extends BaseCommand
{
    protected $group       = 'Sibaja';
    protected $name        = 'sibaja:audit-clean';
    protected $description = 'Hapus audit log lebih dari 90 hari';
    protected $usage       = 'sibaja:audit-clean [days]';
    protected $arguments   = [
        'days' => 'Jumlah hari retensi (default: 90)',
    ];

    public function run(array $params)
    {
        $days = (int) ($params[0] ?? 90);
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        $db = \Config\Database::connect();
        $builder = $db->table('audit_log');
        $builder->where('created_at <', $cutoff);
        $count = $builder->countAllResults(false);
        $builder->delete();

        CLI::write("Menghapus {$count} audit log lebih dari {$days} hari...", 'yellow');
        CLI::write("Audit log berhasil dibersihkan!", 'green');
    }
}
