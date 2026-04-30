<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lock me-2"></i>Ganti Password</h3>
      </div>
      <form action="<?= base_url('auth/change-password') ?>" method="post">
        <?= csrf_field() ?>
        <div class="card-body">
          <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="password_lama">Password Lama <span class="text-danger">*</span></label>
            <input type="password" name="password_lama" id="password_lama"
                   class="form-control <?= isset($errors['password_lama']) ? 'is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['password_lama'] ?? '' ?></div>
          </div>

          <div class="mb-3">
            <label for="password_baru">Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password_baru" id="password_baru"
                   class="form-control <?= isset($errors['password_baru']) ? 'is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['password_baru'] ?? '' ?></div>
            <small class="text-muted">Minimal 8 karakter, mengandung huruf dan angka.</small>
          </div>

          <div class="mb-3">
            <label for="password_konfirmasi">Konfirmasi Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password_konfirmasi" id="password_konfirmasi"
                   class="form-control <?= isset($errors['password_konfirmasi']) ? 'is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['password_konfirmasi'] ?? '' ?></div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
