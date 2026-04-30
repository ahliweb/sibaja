<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="card"><div class="card-header"><h3 class="card-title">Detail User</h3></div>
<div class="card-body">
<table class="table table-bordered">
<tr><th width="200">Nama</th><td><?= esc($data['nama']) ?></td></tr>
<tr><th>Username</th><td><?= esc($data['username']) ?></td></tr>
<tr><th>Email</th><td><?= esc($data['email'] ?? '-') ?></td></tr>
<tr><th>Role</th><td><span class="badge text-bg-<?= $data['role'] === 'admin' ? 'danger' : ($data['role'] === 'petugas' ? 'warning' : 'info') ?>"><?= ucfirst($data['role']) ?></span></td></tr>
<tr><th>SKPD</th><td><?= esc($data['nama_skpd'] ?? '-') ?></td></tr>
<tr><th>Status</th><td><span class="badge text-bg-<?= $data['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($data['status']) ?></span></td></tr>
<tr><th>Login Terakhir</th><td><?= $data['last_login'] ? date('d/m/Y H:i', strtotime($data['last_login'])) : '-' ?></td></tr>
</table>
</div>
<div class="card-footer">
<a href="<?= base_url('users') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
<a href="<?= base_url("users/{$data['id']}/edit") ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
</div></div>
<?= $this->endSection() ?>
