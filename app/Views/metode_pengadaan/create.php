<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> <?= $title ?></h3></div>
  <form action="<?= base_url($isEdit ? "metode-pengadaan/update/{$data['id']}" : 'metode-pengadaan') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3"><label>Nama <span class="text-danger">*</span></label><input type="text" name="nama" class="form-control" value="<?= old('nama', $data['nama'] ?? '') ?>" required></div>
      <div class="mb-3"><label>Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $data['deskripsi'] ?? '') ?></textarea></div>
    </div>
    <div class="card-footer"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button> <a href="<?= base_url('metode-pengadaan') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a></div>
  </form>
</div>
<?= $this->endSection() ?>
