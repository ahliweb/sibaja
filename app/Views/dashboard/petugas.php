<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-2-4 col-6"><div class="small-box bg-primary"><div class="inner"><h3><?= $pengajuan_masuk ?></h3><p>Pengajuan Masuk</p></div><div class="icon"><i class="fas fa-inbox"></i></div></div></div>
  <div class="col-lg-2-4 col-6"><div class="small-box bg-warning"><div class="inner"><h3><?= $dokumen_belum ?></h3><p>Belum Diperiksa</p></div><div class="icon"><i class="fas fa-file-alt"></i></div></div></div>
  <div class="col-lg-2-4 col-6"><div class="small-box bg-orange"><div class="inner"><h3><?= $perlu_perbaikan ?></h3><p>Perlu Perbaikan</p></div><div class="icon"><i class="fas fa-exclamation-triangle"></i></div></div></div>
  <div class="col-lg-2-4 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= $dalam_proses ?></h3><p>Dalam Proses</p></div><div class="icon"><i class="fas fa-spinner"></i></div></div></div>
  <div class="col-lg-2-4 col-6"><div class="small-box bg-success"><div class="inner"><h3><?= $selesai_bulan_ini ?></h3><p>Selesai Bulan Ini</p></div><div class="icon"><i class="fas fa-check-double"></i></div></div></div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header"><h3 class="card-title">Prioritas Pengajuan</h3></div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-hover">
          <thead class="table-light"><tr><th>No</th><th>Tgl Masuk</th><th>Nomor</th><th>SKPD</th><th>Nama Paket</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody>
            <?php $no = 1; foreach ($pengajuan_prioritas as $p): ?>
            <tr>
              <td><?= $no++ ?></td><td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
              <td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td><td><?= esc($p['skpd_id']) ?></td>
              <td><?= esc($p['nama_paket']) ?></td>
              <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
              <td><a href="<?= base_url("pengajuan/{$p['id']}") ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($pengajuan_prioritas)): ?>
            <tr><td colspan="7" class="text-center text-muted">Tidak ada pengajuan prioritas</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Aksi Cepat</h3></div>
      <div class="card-body">
        <a href="<?= base_url('pengajuan/masuk') ?>" class="btn btn-primary w-100 mb-2"><i class="fas fa-inbox"></i> Pengajuan Masuk</a>
        <a href="<?= base_url('dokumen/verify') ?>" class="btn btn-warning w-100 mb-2"><i class="fas fa-check-circle"></i> Verifikasi Dokumen</a>
        <a href="<?= base_url('laporan') ?>" class="btn btn-success w-100"><i class="fas fa-chart-bar"></i> Laporan</a>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
