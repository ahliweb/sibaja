<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'SIBAJA') ?> — SIBAJA</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/sibaja.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?= base_url('img/logo-kobar.png') ?>" alt="Logo Kobar" style="max-height:80px" onerror="this.style.display='none'">
    <br>
    <strong>SIBAJA</strong>
    <p class="text-muted small">Sistem Informasi Barang dan Jasa</p>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sekretariat Daerah Kabupaten Kotawaringin Barat</p>

      <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php endif; ?>

      <?= $this->renderSection('content') ?>
    </div>
  </div>
  <p class="text-center text-muted small mt-3">&copy; <?= date('Y') ?> Setda Kabupaten Kotawaringin Barat</p>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
