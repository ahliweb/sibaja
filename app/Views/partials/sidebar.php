<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="<?= base_url() ?>" class="brand-link">
      <img src="<?= base_url('img/logo-kobar.png') ?>" alt="Logo Kobar"
           class="brand-image opacity-75 shadow" onerror="this.style.display='none'">
      <span class="brand-text fw-light">SIBAJA</span>
    </a>
  </div>

  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <i class="fas fa-user-circle fa-2x text-white"></i>
    </div>
    <div class="info">
      <a href="#" class="d-block"><?= esc(session('nama') ?? 'User') ?></a>
      <span class="badge text-bg-<?= session('role') === 'admin' ? 'danger' : (session('role') === 'petugas' ? 'warning' : 'info') ?>">
        <?= ucfirst(session('role') ?? '-') ?>
      </span>
    </div>
  </div>

  <nav class="mt-2">
    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
      <?= $this->include('partials/sidebar_menu') ?>
    </ul>
  </nav>
</aside>
