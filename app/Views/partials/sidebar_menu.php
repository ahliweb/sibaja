<?php
$role = session('role') ?? 'guest';
$currentUrl = current_url();
$isActive = function (string $url) use ($currentUrl): bool {
    return str_contains($currentUrl, base_url($url));
};

$menu = [];

if ($role === 'admin') {
    $menu = [
        ['title' => 'Dashboard',        'url' => 'dashboard',           'icon' => 'fas fa-tachometer-alt'],
        ['header' => 'Master Data'],
        ['title' => 'Data SKPD',        'url' => 'skpd',                'icon' => 'fas fa-building'],
        ['title' => 'Data User',        'url' => 'users',               'icon' => 'fas fa-users'],
        ['title' => 'Data Petugas',     'url' => 'petugas',             'icon' => 'fas fa-user-check'],
        ['title' => 'Jenis Pengadaan',  'url' => 'jenis-pengadaan',     'icon' => 'fas fa-tags'],
        ['title' => 'Metode Pengadaan', 'url' => 'metode-pengadaan',    'icon' => 'fas fa-cogs'],
        ['title' => 'Tahun Anggaran',   'url' => 'tahun-anggaran',      'icon' => 'fas fa-calendar-alt'],
        ['header' => 'Pengajuan Barang/Jasa'],
        ['title' => 'Semua Pengajuan',  'url' => 'pengajuan',           'icon' => 'fas fa-file-alt'],
        ['title' => 'Pengajuan Masuk',  'url' => 'pengajuan/masuk',     'icon' => 'fas fa-inbox'],
        ['title' => 'Pengajuan Diproses','url' => 'pengajuan/diproses', 'icon' => 'fas fa-spinner'],
        ['title' => 'Pengajuan Selesai','url' => 'pengajuan/selesai',   'icon' => 'fas fa-check-double'],
        ['title' => 'Pengajuan Ditolak','url' => 'pengajuan/ditolak',   'icon' => 'fas fa-times-circle'],
        ['header' => 'Dokumen Pengadaan'],
        ['title' => 'Verifikasi Dokumen','url' => 'dokumen/verify',     'icon' => 'fas fa-check-circle'],
        ['header' => 'Laporan'],
        ['title' => 'Laporan',          'url' => 'laporan',             'icon' => 'fas fa-chart-bar'],
        ['header' => 'Sistem'],
        ['title' => 'Audit Log',        'url' => 'audit',               'icon' => 'fas fa-clipboard-list'],
        ['title' => 'Pengaturan',       'url' => 'settings',            'icon' => 'fas fa-cog'],
    ];
} elseif ($role === 'petugas') {
    $menu = [
        ['title' => 'Dashboard',        'url' => 'dashboard',           'icon' => 'fas fa-tachometer-alt'],
        ['header' => 'Pengajuan'],
        ['title' => 'Pengajuan Masuk',  'url' => 'pengajuan/masuk',     'icon' => 'fas fa-inbox'],
        ['title' => 'Semua Pengajuan',  'url' => 'pengajuan',           'icon' => 'fas fa-file-alt'],
        ['title' => 'Pengajuan Diproses','url' => 'pengajuan/diproses', 'icon' => 'fas fa-spinner'],
        ['title' => 'Pengajuan Selesai','url' => 'pengajuan/selesai',   'icon' => 'fas fa-check-double'],
        ['title' => 'Pengajuan Ditolak','url' => 'pengajuan/ditolak',   'icon' => 'fas fa-times-circle'],
        ['header' => 'Dokumen'],
        ['title' => 'Verifikasi Dokumen','url' => 'dokumen/verify',     'icon' => 'fas fa-check-circle'],
        ['header' => 'Laporan'],
        ['title' => 'Laporan',          'url' => 'laporan',             'icon' => 'fas fa-chart-bar'],
    ];
} elseif ($role === 'skpd') {
    $menu = [
        ['title' => 'Dashboard',        'url' => 'dashboard',           'icon' => 'fas fa-tachometer-alt'],
        ['header' => 'Pengajuan Saya'],
        ['title' => 'Pengajuan Saya',   'url' => 'pengajuan/my',        'icon' => 'fas fa-file-alt'],
        ['title' => 'Tambah Pengajuan', 'url' => 'pengajuan/create',    'icon' => 'fas fa-plus-circle'],
        ['header' => 'SKPD'],
        ['title' => 'Profil SKPD',      'url' => 'profil',              'icon' => 'fas fa-building'],
    ];
}

// Common bottom items
$commonBottom = [
    ['divider' => true],
    ['title' => 'Ganti Password',       'url' => 'auth/change-password','icon' => 'fas fa-lock'],
    ['title' => 'Logout',               'url' => 'logout',              'icon' => 'fas fa-sign-out-alt'],
];

$menu = array_merge($menu, $commonBottom);
?>

<?php foreach ($menu as $item): ?>
  <?php if (isset($item['header'])): ?>
    <li class="nav-header"><?= esc($item['header']) ?></li>
  <?php elseif (isset($item['divider'])): ?>
    <li class="nav-item"><hr class="nav-divider"></li>
  <?php else: ?>
    <li class="nav-item">
      <a href="<?= base_url($item['url']) ?>" class="nav-link <?= $isActive($item['url']) ? 'active' : '' ?>">
        <i class="nav-icon <?= $item['icon'] ?>"></i>
        <p><?= esc($item['title']) ?></p>
      </a>
    </li>
  <?php endif; ?>
<?php endforeach; ?>
