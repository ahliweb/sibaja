<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card">
  <div class="card-header"><h3 class="card-title">Profil SKPD</h3></div>
  <form action="<?= base_url('profil') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Kode SKPD</label><div class="col-sm-9"><input type="text" class="form-control" value="<?= esc($skpd['kode_skpd'] ?? '-') ?>" readonly></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Nama SKPD</label><div class="col-sm-9"><input type="text" class="form-control" value="<?= esc($skpd['nama_skpd'] ?? '-') ?>" readonly></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Kepala SKPD</label><div class="col-sm-9"><input type="text" class="form-control" value="<?= esc($skpd['kepala_skpd'] ?? '-') ?>" readonly></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">NIP Kepala</label><div class="col-sm-9"><input type="text" class="form-control" value="<?= esc($skpd['nip_kepala'] ?? '-') ?>" readonly></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Kontak Operator</label><div class="col-sm-9"><input type="text" name="kontak" class="form-control" value="<?= esc($skpd['kontak'] ?? '') ?>"></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Email</label><div class="col-sm-9"><input type="email" name="email" class="form-control" value="<?= esc($skpd['email'] ?? '') ?>"></div></div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
      <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
