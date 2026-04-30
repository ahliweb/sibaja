<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'SIBAJA') ?> — SIBAJA</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="<?= base_url('css/sibaja.css') ?>">
</head>
<body class="layout-fixed sidebar-expand-lg">
<div class="app-wrapper">

  <?= $this->include('partials/navbar') ?>
  <?= $this->include('partials/sidebar') ?>

  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <?= $this->include('partials/breadcrumb') ?>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <?= $this->include('partials/flash') ?>
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </main>

  <?= $this->include('partials/footer') ?>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<?= $this->include('partials/modal_confirm') ?>
<?= $this->renderSection('scripts') ?>
</body>
</html>
