<?php

declare(strict_types=1);

require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();

require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::preload($paths);
