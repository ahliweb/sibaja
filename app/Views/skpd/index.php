<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Data SKPD</h3>
    <div class="card-tools">
      <a href="<?= base_url('skpd/create') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah SKPD</a>
    </div>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tabelSkpd">
      <thead class="table-light"><tr><th>No</th><th>Kode SKPD</th><th>Nama SKPD</th><th>Kepala SKPD</th><th>Kontak</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($skpd as $row): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= esc($row['kode_skpd']) ?></td><td><?= esc($row['nama_skpd']) ?></td>
          <td><?= esc($row['kepala_skpd'] ?? '-') ?></td><td><?= esc($row['kontak'] ?? '-') ?></td>
          <td><span class="badge text-bg-<?= $row['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($row['status']) ?></span></td>
          <td nowrap>
            <a href="<?= base_url("skpd/{$row['id']}") ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
            <a href="<?= base_url("skpd/{$row['id']}/edit") ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
            <button class="btn btn-sm btn-danger btn-hapus" data-url="<?= base_url("skpd/{$row['id']}/delete") ?>" data-nama="<?= esc($row['nama_skpd']) ?>" title="Nonaktifkan"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>$(function(){$('#tabelSkpd').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:25})});</script>
<?= $this->endSection() ?>
