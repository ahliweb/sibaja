<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner"><h3><?= $total_skpd ?></h3><p>Total SKPD</p></div>
      <div class="icon"><i class="fas fa-building"></i></div>
      <a href="<?= base_url('skpd') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner"><h3><?= $total_user ?></h3><p>Total User</p></div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <a href="<?= base_url('users') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner"><h3><?= $total_pengajuan ?></h3><p>Total Pengajuan</p></div>
      <div class="icon"><i class="fas fa-file-alt"></i></div>
      <a href="<?= base_url('pengajuan') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner"><h3><?= $count_perbaikan ?></h3><p>Perlu Perbaikan</p></div>
      <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
      <a href="<?= base_url('pengajuan?status=perlu_perbaikan') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Pengajuan Terbaru</h3>
        <div class="card-tools">
          <a href="<?= base_url('pengajuan') ?>" class="btn btn-sm btn-primary"><i class="fas fa-list"></i> Semua</a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-hover">
          <thead class="table-light">
            <tr><th>No</th><th>Nomor</th><th>SKPD</th><th>Nama Paket</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($pengajuan_terbaru as $p): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= esc($p['nomor_pengajuan']) ?></td>
              <td><?= esc($p['skpd_id']) ?></td>
              <td><?= esc($p['nama_paket']) ?></td>
              <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
              <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
              <td>
                <a href="<?= base_url("pengajuan/{$p['id']}") ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($pengajuan_terbaru)): ?>
            <tr><td colspan="7" class="text-center text-muted">Belum ada pengajuan</td></tr>
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
        <a href="<?= base_url('skpd/create') ?>" class="btn btn-primary w-100 mb-2"><i class="fas fa-plus"></i> Tambah SKPD</a>
        <a href="<?= base_url('users/create') ?>" class="btn btn-success w-100 mb-2"><i class="fas fa-user-plus"></i> Tambah User</a>
        <a href="<?= base_url('pengajuan') ?>" class="btn btn-info w-100 mb-2"><i class="fas fa-list"></i> Semua Pengajuan</a>
        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary w-100"><i class="fas fa-chart-bar"></i> Laporan</a>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
