<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="error-page">
  <h2 class="headline text-warning">404</h2>
  <div class="error-content">
    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Halaman Tidak Ditemukan</h3>
    <p>Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
    <p><a href="<?= base_url('dashboard') ?>" class="btn btn-primary">
      <i class="fas fa-home"></i> Kembali ke Dashboard
    </a></p>
  </div>
</div>
<?= $this->endSection() ?>
