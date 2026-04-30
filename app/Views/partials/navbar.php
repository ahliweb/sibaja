<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block">
        <span class="navbar-brand ms-2 mb-0 h6">SIBAJA</span>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <i class="fas fa-user-circle fa-lg me-1"></i>
          <span class="d-none d-md-inline"><?= esc(session('nama') ?? 'User') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="user-header">
            <p class="mb-1"><?= esc(session('nama') ?? 'User') ?></p>
            <small>
              <span class="badge text-bg-<?= session('role') === 'admin' ? 'danger' : (session('role') === 'petugas' ? 'warning' : 'info') ?>">
                <?= ucfirst(session('role') ?? '-') ?>
              </span>
            </small>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a href="<?= base_url('auth/change-password') ?>" class="dropdown-item">
              <i class="fas fa-lock me-2"></i> Ganti Password
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
