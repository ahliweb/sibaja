<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title"><?= $title ?></h3>
    <div class="card-tools"><a href="<?= base_url('pengajuan/create') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tabelPengajuanSaya">
      <thead class="table-light"><tr><th>No</th><th>Nomor</th><th>Nama Paket</th><th>Tahun</th><th>Pagu</th><th>Status</th><th>Tgl</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($pengajuan as $p): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td><td><?= esc($p['nama_paket']) ?></td>
          <td><?= esc($p['tahun_anggaran_id'] ?? '-') ?></td><td><?= formatRupiah($p['pagu_anggaran'] ?? 0) ?></td>
          <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
          <td><?= date('d/m/Y', strtotime($p['tanggal'] ?? '')) ?></td>
          <td nowrap>
            <a href="<?= base_url("pengajuan/{$p['id']}") ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
            <?php if (in_array($p['status'], ['draft', 'perlu_perbaikan'])): ?>
            <a href="<?= base_url("pengajuan/{$p['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <?php endif; ?>
            <?php if ($p['status'] === 'draft'): ?>
            <a href="<?= base_url("dokumen/upload/{$p['id']}") ?>" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script>$(function(){$('#tabelPengajuanSaya').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:25,columnDefs:[{targets:-1,orderable:false}]})});</script><?= $this->endSection() ?>
