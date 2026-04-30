<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="fas fa-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fas fa-times-circle me-1"></i> <?= session()->getFlashdata('error') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('warning')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle me-1"></i> <?= session()->getFlashdata('warning') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('info')): ?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <i class="fas fa-info-circle me-1"></i> <?= session()->getFlashdata('info') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
