<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card">
  <div class="card-header"><h3 class="card-title">Detail Audit Log</h3></div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr><th width="180">Waktu</th><td><?= date('d/m/Y H:i', strtotime($log['created_at'] ?? '')) ?></td></tr>
      <tr><th>User ID</th><td><?= esc($log['user_id'] ?? '-') ?></td></tr>
      <tr><th>Role</th><td><?= esc($log['role'] ?? '-') ?></td></tr>
      <tr><th>Modul</th><td><?= esc($log['modul'] ?? '-') ?></td></tr>
      <tr><th>Aksi</th><td><span class="badge text-bg-<?= ($log['aksi'] ?? '') === 'login' ? 'info' : (($log['aksi'] ?? '') === 'logout' ? 'secondary' : (($log['aksi'] ?? '') === 'create' ? 'success' : (($log['aksi'] ?? '') === 'delete' ? 'danger' : 'warning'))) ?>"><?= esc($log['aksi'] ?? '-') ?></span></td></tr>
      <tr><th>Deskripsi</th><td><?= esc($log['deskripsi'] ?? '-') ?></td></tr>
      <tr><th>IP Address</th><td><?= esc($log['ip_address'] ?? '-') ?></td></tr>
      <tr><th>User Agent</th><td style="word-break:break-all"><small><?= esc($log['user_agent'] ?? '-') ?></small></td></tr>
    </table>
  </div>
  <div class="card-footer">
    <a href="<?= base_url('audit') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>
<?= $this->endSection() ?>
