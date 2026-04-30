<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<?php if ($count_perbaikan > 0): ?>
<div class="alert alert-warning alert-dismissible fade show">
  <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian!</strong> Ada <strong><?= $count_perbaikan ?></strong> pengajuan yang perlu diperbaiki. Silakan cek catatan petugas.
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Identitas SKPD</h3></div>
      <div class="card-body">
        <table class="table table-sm">
          <tr><th>Nama SKPD</th><td><?= esc($skpd['nama_skpd'] ?? '-') ?></td></tr>
          <tr><th>Kode SKPD</th><td><?= esc($skpd['kode_skpd'] ?? '-') ?></td></tr>
          <tr><th>Operator</th><td><?= esc(session('nama')) ?></td></tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <a href="<?= base_url('pengajuan/create') ?>" class="btn btn-primary btn-lg w-100 mb-3">
      <i class="fas fa-plus-circle"></i> Tambah Pengajuan Baru
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-2 col-4"><div class="small-box bg-secondary"><div class="inner"><h3><?= $count_draft ?></h3><p>Draft</p></div><div class="icon"><i class="fas fa-pencil-alt"></i></div></div></div>
  <div class="col-lg-2 col-4"><div class="small-box bg-primary"><div class="inner"><h3><?= $count_diajukan ?></h3><p>Diajukan</p></div><div class="icon"><i class="fas fa-paper-plane"></i></div></div></div>
  <div class="col-lg-2 col-4"><div class="small-box bg-warning"><div class="inner"><h3><?= $count_perbaikan ?></h3><p>Perlu Perbaikan</p></div><div class="icon"><i class="fas fa-exclamation-triangle"></i></div></div></div>
  <div class="col-lg-2 col-4"><div class="small-box bg-info"><div class="inner"><h3><?= $count_proses ?></h3><p>Dalam Proses</p></div><div class="icon"><i class="fas fa-spinner"></i></div></div></div>
  <div class="col-lg-2 col-4"><div class="small-box bg-success"><div class="inner"><h3><?= $count_selesai ?></h3><p>Selesai</p></div><div class="icon"><i class="fas fa-check-double"></i></div></div></div>
  <div class="col-lg-2 col-4"><div class="small-box bg-info"><div class="inner"><h3><?= $total_pengajuan ?></h3><p>Total</p></div><div class="icon"><i class="fas fa-file-alt"></i></div></div></div>
</div>

<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title">Pengajuan Terbaru</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-striped table-hover dataTable" id="tabelPengajuanSaya">
      <thead class="table-light"><tr><th>No</th><th>Nomor</th><th>Nama Paket</th><th>Tahun</th><th>Pagu</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($pengajuan_terbaru as $p): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td>
          <td><?= esc($p['nama_paket']) ?></td>
          <td><?= esc($p['tahun_anggaran_id'] ?? '-') ?></td>
          <td><?= formatRupiah($p['pagu_anggaran'] ?? 0) ?></td>
          <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
          <td><?= date('d/m/Y', strtotime($p['tanggal'] ?? '')) ?></td>
          <td>
            <a href="<?= base_url("pengajuan/{$p['id']}") ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
            <?php if (in_array($p['status'], ['draft', 'perlu_perbaikan'])): ?>
            <a href="<?= base_url("pengajuan/{$p['id']}/edit") ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($pengajuan_terbaru)): ?>
        <tr><td colspan="8" class="text-center text-muted">Belum ada pengajuan</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(function(){ $('#tabelPengajuanSaya').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:10,order:[[6,'desc']]}); });
</script>
<?= $this->endSection() ?>
