<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<form action="<?= base_url('login') ?>" method="post">
  <?= csrf_field() ?>
  <div class="mb-3">
    <div class="input-group">
      <input type="text" name="username" class="form-control <?= session('error') ? 'is-invalid' : '' ?>"
             placeholder="Username" autofocus required value="<?= old('username') ?>">
      <span class="input-group-text"><i class="fas fa-user"></i></span>
    </div>
  </div>
  <div class="mb-3">
    <div class="input-group">
      <input type="password" name="password" class="form-control <?= session('error') ? 'is-invalid' : '' ?>"
             placeholder="Password" required>
      <span class="input-group-text"><i class="fas fa-lock"></i></span>
    </div>
  </div>
  <div class="row">
    <div class="col-8">
      <div class="form-check">
        <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Ingat Saya</label>
      </div>
    </div>
    <div class="col-4">
      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-sign-in-alt"></i> Masuk
      </button>
    </div>
  </div>
</form>
<?= $this->endSection() ?>
