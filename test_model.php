<?php
require 'public/../app/Config/Paths.php';
$paths = new Config\Paths();
chdir('/var/www/html/public');
require '/var/www/html/app/Config/Paths.php';
$p = new \Config\Paths();
require $p->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootWeb($p);
