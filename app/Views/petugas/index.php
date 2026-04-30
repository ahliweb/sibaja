<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title">Data Petugas</h3>
    <div class="card-tools"><a href="<?= base_url('petugas/create') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah Petugas</a></div>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tabelPetugas">
      <thead class="table-light"><tr><th>No</th><th>Nama</th><th>Username</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($petugas as $row): ?>
        <tr><td><?= $no++ ?></td><td><?= esc($row['nama']) ?></td><td><?= esc($row['username']) ?></td>
          <td><?= esc($row['email'] ?? '-') ?></td>
          <td><span class="badge text-bg-<?= $row['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($row['status']) ?></span></td>
          <td>
            <a href="<?= base_url("petugas/edit/{$row['id']}") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <button class="btn btn-sm btn-danger btn-hapus" data-url="<?= base_url("petugas/{$row['id']}") ?>" data-nama="<?= esc($row['nama']) ?>"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script>$(function(){$('#tabelPetugas').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:25})});</script><?= $this->endSection() ?>
