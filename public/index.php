<?php

if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', filter_var(getenv('CI_DEBUG'), FILTER_VALIDATE_BOOLEAN));
}

// Path to the front controller
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Path to this file's directory
define('ROOTPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Path to the writable directory
define('WRITEPATH', ROOTPATH . 'writable' . DIRECTORY_SEPARATOR);

// Path to the app directory
define('APPPATH', ROOTPATH . 'app' . DIRECTORY_SEPARATOR);

// ENVIRONMENT
define('ENVIRONMENT', getenv('CI_ENVIRONMENT') ?: 'production');

// Load bootstrap
require ROOTPATH . 'vendor/autoload.php';

// Load framework
$app = require ROOTPATH . 'vendor/codeigniter4/framework/system/bootstrap.php';
$app->run();
