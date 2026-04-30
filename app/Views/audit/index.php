<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title">Audit Log Aktivitas Sistem</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped dataTable" id="tabelAudit">
      <thead class="table-light"><tr><th>No</th><th>Waktu</th><th>User</th><th>Role</th><th>Modul</th><th>Aksi</th><th>Deskripsi</th><th>IP</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($logs as $l): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= date('d/m/Y H:i', strtotime($l['created_at'])) ?></td>
          <td><?= esc($l['user_id']) ?></td><td><?= esc($l['role'] ?? '-') ?></td>
          <td><?= esc($l['modul']) ?></td>
          <td><span class="badge text-bg-<?= $l['aksi'] === 'login' ? 'info' : ($l['aksi'] === 'logout' ? 'secondary' : ($l['aksi'] === 'create' ? 'success' : ($l['aksi'] === 'delete' ? 'danger' : 'warning'))) ?>"><?= esc($l['aksi']) ?></span></td>
          <td><?= esc(mb_strimwidth($l['deskripsi'] ?? '', 0, 80, '...')) ?></td>
          <td><?= esc($l['ip_address'] ?? '-') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script>$(function(){$('#tabelAudit').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:50,order:[[1,'desc']]})});</script><?= $this->endSection() ?>
