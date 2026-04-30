<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SibajaReset extends BaseCommand
{
    protected $group       = 'Sibaja';
    protected $name        = 'sibaja:reset';
    protected $description = 'Reset database (migrate:refresh + seed AdminSeeder)';

    public function run(array $params)
    {
        CLI::write('Mereset database SIBAJA...', 'yellow');

        // Refresh migrations
        $result = shell_exec('php ' . ROOTPATH . 'spark migrate:refresh -f 2>&1');
        CLI::write($result);

        // Run seeder
        $result = shell_exec('php ' . ROOTPATH . 'spark db:seed AdminSeeder 2>&1');
        CLI::write($result);

        CLI::write('Database SIBAJA berhasil direset!', 'green');
    }
}
