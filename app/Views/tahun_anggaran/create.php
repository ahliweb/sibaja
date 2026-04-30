<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> <?= $title ?></h3></div>
  <form action="<?= base_url($isEdit ? "tahun-anggaran/{$data['id']}/update" : 'tahun-anggaran/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3"><label>Tahun <span class="text-danger">*</span></label><input type="number" name="tahun" class="form-control" value="<?= old('tahun', $data['tahun'] ?? '') ?>" min="2000" max="2099" required></div>
    </div>
    <div class="card-footer"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button> <a href="<?= base_url('tahun-anggaran') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a></div>
  </form>
</div>
<?= $this->endSection() ?>
