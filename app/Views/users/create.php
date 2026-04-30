<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> User</h3></div>
  <form action="<?= base_url($isEdit ? "users/{$data['id']}/update" : 'users/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
        <div class="col-sm-9"><input type="text" name="nama" class="form-control" value="<?= old('nama', $data['nama'] ?? '') ?>" required></div>
      </div>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Username <span class="text-danger">*</span></label>
        <div class="col-sm-9"><input type="text" name="username" class="form-control" value="<?= old('username', $data['username'] ?? '') ?>" required></div>
      </div>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9"><input type="email" name="email" class="form-control" value="<?= old('email', $data['email'] ?? '') ?>"></div>
      </div>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Password <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
        <div class="col-sm-9"><input type="password" name="password" class="form-control" <?= $isEdit ? 'placeholder="Kosongkan jika tidak diubah"' : 'required' ?>></div>
      </div>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <select name="role" class="form-select" required>
            <option value="">Pilih Role</option>
            <option value="admin" <?= old('role', $data['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="petugas" <?= old('role', $data['role'] ?? '') === 'petugas' ? 'selected' : '' ?>>Petugas</option>
            <option value="skpd" <?= old('role', $data['role'] ?? '') === 'skpd' ? 'selected' : '' ?>>User SKPD</option>
          </select>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">SKPD</label>
        <div class="col-sm-9">
          <select name="skpd_id" class="form-select">
            <option value="">-- Pilih SKPD --</option>
            <?php foreach ($skpdList as $s): ?>
            <option value="<?= $s['id'] ?>" <?= old('skpd_id', $data['skpd_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= esc($s['nama_skpd']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
      <a href="<?= base_url('users') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
