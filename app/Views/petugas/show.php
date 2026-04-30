<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card"><div class="card-header"><h3 class="card-title">Detail Petugas</h3></div>
<div class="card-body">
<table class="table table-bordered">
<tr><th width="200">Nama</th><td><?= esc($data['nama'] ?? '-') ?></td></tr>
<tr><th>Username</th><td><?= esc($data['username'] ?? '-') ?></td></tr>
<tr><th>Email</th><td><?= esc($data['email'] ?? '-') ?></td></tr>
<tr><th>Status</th><td><span class="badge text-bg-<?= ($data['status'] ?? '') === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($data['status'] ?? '-') ?></span></td></tr>
</table>
</div>
<div class="card-footer"><a href="<?= base_url('petugas') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a> <a href="<?= base_url("petugas/{$data['id']}/edit") ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></div>
</div>
<?= $this->endSection() ?>
