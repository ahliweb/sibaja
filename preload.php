<?php

use CodeIgniter\Config\DotEnv;

// Load .env
(new DotEnv(ROOTPATH))->load();

defined('CI_DEBUG') || define('CI_DEBUG', ENVIRONMENT !== 'production');
