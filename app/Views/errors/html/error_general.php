<?php if (session()->has('isLoggedIn')): ?>
<?= $this->extend('layouts/adminlte') ?>
<?php else: ?>
<?= $this->extend('layouts/auth') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="error-page">
  <h2 class="headline text-danger">Error</h2>
  <div class="error-content">
    <h3><i class="fas fa-exclamation-circle text-danger"></i> Terjadi Kesalahan</h3>
    <p><?= esc($message ?? 'Terjadi kesalahan pada server. Silakan coba lagi.') ?></p>
    <p><a href="<?= base_url('dashboard') ?>" class="btn btn-primary">
      <i class="fas fa-home"></i> Kembali ke Dashboard
    </a></p>
  </div>
</div>
<?= $this->endSection() ?>
