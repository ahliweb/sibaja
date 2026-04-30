<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> Petugas</h3></div>
  <form action="<?= base_url($isEdit ? "petugas/{$data['id']}/update" : 'petugas/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3"><label>Nama <span class="text-danger">*</span></label><input type="text" name="nama" class="form-control" value="<?= old('nama', $data['nama'] ?? '') ?>" required></div>
      <div class="mb-3"><label>Username <span class="text-danger">*</span></label><input type="text" name="username" class="form-control" value="<?= old('username', $data['username'] ?? '') ?>" required></div>
      <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= old('email', $data['email'] ?? '') ?>"></div>
      <div class="mb-3"><label>Password <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label><input type="password" name="password" class="form-control" <?= $isEdit ? 'placeholder="Kosongkan jika tidak diubah"' : 'required' ?>></div>
    </div>
    <div class="card-footer"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button> <a href="<?= base_url('petugas') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a></div>
  </form>
</div>
<?= $this->endSection() ?>
