<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth (public)
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Landing → redirect to appropriate dashboard
$routes->get('/', 'Dashboard::index');

// Protected routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Ganti Password
    $routes->get('auth/change-password', 'Auth::changePassword');
    $routes->post('auth/change-password', 'Auth::updatePassword');

    // Admin only
    $routes->group('', ['filter' => 'auth:admin'], static function ($routes) {
        $routes->presenter('skpd', ['controller' => 'Skpd']);
        $routes->presenter('users', ['controller' => 'Users']);
        $routes->presenter('petugas', ['controller' => 'Petugas']);
        $routes->presenter('jenis-pengadaan', ['controller' => 'JenisPengadaan']);
        $routes->presenter('metode-pengadaan', ['controller' => 'MetodePengadaan']);
        $routes->presenter('tahun-anggaran', ['controller' => 'TahunAnggaran']);
        $routes->get('audit', 'Audit::index');
        $routes->get('audit/(:num)', 'Audit::show/$1');
        $routes->get('settings', 'Settings::index');
        $routes->post('settings', 'Settings::update');
    });

    // Admin + Petugas
    $routes->group('', ['filter' => 'auth:admin,petugas'], static function ($routes) {
        $routes->get('pengajuan/masuk', 'Pengajuan::masuk');
        $routes->get('pengajuan/diproses', 'Pengajuan::diproses');
        $routes->get('pengajuan/selesai', 'Pengajuan::selesai');
        $routes->get('pengajuan/ditolak', 'Pengajuan::ditolak');
        $routes->get('pengajuan/(:num)/update-status', 'Pengajuan::statusForm/$1');
        $routes->post('pengajuan/(:num)/update-status', 'Pengajuan::updateStatus/$1');
        $routes->get('pengajuan', 'Pengajuan::index');

        $routes->get('dokumen/verify', 'Dokumen::verifyIndex');
        $routes->post('dokumen/(:num)/verify', 'Dokumen::doVerify/$1');

        $routes->get('laporan', 'Laporan::index');
        $routes->get('laporan/pdf', 'Laporan::pdf');
        $routes->get('laporan/excel', 'Laporan::excel');
        $routes->get('laporan/print', 'Laporan::printView');
    });

    // All authenticated users
    $routes->get('pengajuan/my', 'Pengajuan::myIndex');
    $routes->get('pengajuan/create', 'Pengajuan::create');
    $routes->post('pengajuan/store', 'Pengajuan::store');
    $routes->get('pengajuan/(:num)', 'Pengajuan::show/$1');
    $routes->get('pengajuan/(:num)/edit', 'Pengajuan::edit/$1');
    $routes->post('pengajuan/(:num)/update', 'Pengajuan::update/$1');
    $routes->post('pengajuan/(:num)/kirim', 'Pengajuan::kirim/$1');

    $routes->get('dokumen/upload/(:num)', 'Dokumen::upload/$1');
    $routes->post('dokumen/upload/(:num)', 'Dokumen::doUpload/$1');
    $routes->get('dokumen/(:num)/download', 'Dokumen::download/$1');
    $routes->delete('dokumen/(:num)', 'Dokumen::delete/$1');

    $routes->get('profil', 'Profil::index');
    $routes->post('profil', 'Profil::update');
});
