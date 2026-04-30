<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card">
  <div class="card-header"><h3 class="card-title">Pengaturan Aplikasi</h3></div>
  <form action="<?= base_url('settings') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3"><label>Nama Instansi</label><input type="text" name="instansi" class="form-control" value="<?= esc($settings['instansi'] ?? 'Sekretariat Daerah Kabupaten Kotawaringin Barat') ?>"></div>
      <div class="mb-3"><label>Nama Aplikasi</label><input type="text" name="app_name" class="form-control" value="<?= esc($settings['app_name'] ?? 'SIBAJA') ?>"></div>
      <div class="mb-3"><label>Nama Singkat</label><input type="text" name="app_short" class="form-control" value="<?= esc($settings['app_short'] ?? 'SIBAJA') ?>"></div>
      <div class="mb-3"><label>Maksimal Upload File (MB)</label><input type="number" name="max_upload_mb" class="form-control" value="<?= esc($settings['max_upload_mb'] ?? '10') ?>"></div>
    </div>
    <div class="card-footer"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Pengaturan</button></div>
  </form>
</div>
<?= $this->endSection() ?>
