<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title"><?= $title ?></h3>
    <div class="card-tools"><a href="<?= base_url('metode-pengadaan/create') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tabelData">
      <thead class="table-light"><tr><th>No</th><th>Nama</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($data as $row): ?>
        <tr><td><?= $no++ ?></td><td><?= esc($row['nama']) ?></td><td><?= esc($row['deskripsi'] ?? '-') ?></td>
          <td><span class="badge text-bg-<?= $row['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($row['status']) ?></span></td>
          <td><a href="<?= base_url("metode-pengadaan/edit/{$row['id']}") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <button class="btn btn-sm btn-danger btn-hapus" data-url="<?= base_url("metode-pengadaan/delete/{$row['id']}") ?>" data-nama="<?= esc($row['nama']) ?>"><i class="fas fa-trash"></i></button></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script>$(function(){$('#tabelData').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true})});</script><?= $this->endSection() ?>
