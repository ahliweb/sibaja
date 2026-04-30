<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header"><h3 class="card-title">Detail SKPD</h3></div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr><th width="200">Kode SKPD</th><td><?= esc($data['kode_skpd'] ?? '-') ?></td></tr>
      <tr><th>Nama SKPD</th><td><?= esc($data['nama_skpd'] ?? '-') ?></td></tr>
      <tr><th>Kepala SKPD</th><td><?= esc($data['kepala_skpd'] ?? '-') ?></td></tr>
      <tr><th>NIP Kepala</th><td><?= esc($data['nip_kepala'] ?? '-') ?></td></tr>
      <tr><th>Alamat</th><td><?= esc($data['alamat'] ?? '-') ?></td></tr>
      <tr><th>Kontak</th><td><?= esc($data['kontak'] ?? '-') ?></td></tr>
      <tr><th>Email</th><td><?= esc($data['email'] ?? '-') ?></td></tr>
      <tr><th>Status</th><td><span class="badge text-bg-<?= $data['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($data['status']) ?></span></td></tr>
    </table>
  </div>
  <div class="card-footer">
    <a href="<?= base_url('skpd') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    <a href="<?= base_url("skpd/{$data['id']}/edit") ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
  </div>
</div>
<?= $this->endSection() ?>
