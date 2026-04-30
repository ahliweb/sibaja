<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title">Filter Laporan</h3></div>
  <div class="card-body">
    <form method="get" action="<?= base_url('laporan') ?>">
      <div class="row g-2">
        <div class="col-md-2 col-sm-4">
          <select name="tahun_id" class="form-select form-select-sm"><option value="">Tahun Anggaran</option>
            <?php foreach ($tahunList as $t): ?><option value="<?= $t['id'] ?>" <?= ($filter['tahun_id'] ?? '') == $t['id'] ? 'selected' : '' ?>><?= $t['tahun'] ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 col-sm-4">
          <select name="skpd_id" class="form-select form-select-sm"><option value="">Semua SKPD</option>
            <?php foreach ($skpdList as $s): ?><option value="<?= $s['id'] ?>" <?= ($filter['skpd_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= esc($s['nama_skpd']) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2 col-sm-4">
          <select name="status" class="form-select form-select-sm"><option value="">Semua Status</option>
            <option value="draft" <?= ($filter['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="diajukan" <?= ($filter['status'] ?? '') === 'diajukan' ? 'selected' : '' ?>>Diajukan</option>
            <option value="diverifikasi" <?= ($filter['status'] ?? '') === 'diverifikasi' ? 'selected' : '' ?>>Diverifikasi</option>
            <option value="dalam_proses" <?= ($filter['status'] ?? '') === 'dalam_proses' ? 'selected' : '' ?>>Dalam Proses</option>
            <option value="selesai" <?= ($filter['status'] ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="perlu_perbaikan" <?= ($filter['status'] ?? '') === 'perlu_perbaikan' ? 'selected' : '' ?>>Perlu Perbaikan</option>
            <option value="ditolak" <?= ($filter['status'] ?? '') === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
          </select>
        </div>
        <div class="col-md-2 col-sm-12">
          <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
          <a href="<?= base_url('laporan') ?>" class="btn btn-sm btn-secondary w-100 mt-1"><i class="fas fa-undo"></i> Reset</a>
        </div>
        <div class="col-md-2 col-sm-12 ms-auto">
          <a href="<?= base_url('laporan/pdf') ?>" class="btn btn-sm btn-danger w-100"><i class="fas fa-file-pdf"></i> PDF</a>
          <a href="<?= base_url('laporan/excel') ?>" class="btn btn-sm btn-success w-100 mt-1"><i class="fas fa-file-excel"></i> Excel</a>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= count($pengajuan) ?></h3><p>Total</p></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3><?= $countSelesai ?></h3><p>Selesai</p></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= $countProses ?></h3><p>Dalam Proses</p></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3><?= $countPerbaikan ?></h3><p>Perlu Perbaikan</p></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-danger"><div class="inner"><h3><?= $countDitolak ?></h3><p>Ditolak</p></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-primary"><div class="inner"><h3><?= formatRupiah($totalPagu) ?></h3><p>Total Pagu</p></div></div></div>
</div>

<div class="card">
  <div class="card-header"><h3 class="card-title">Hasil Laporan</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped dataTable" id="tabelLaporan">
      <thead class="table-light"><tr><th>No</th><th>Nomor</th><th>Tgl</th><th>SKPD</th><th>Nama Paket</th><th>Pagu</th><th>Status</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($pengajuan as $p): ?>
        <tr><td><?= $no++ ?></td><td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td><td><?= date('d/m/Y', strtotime($p['tanggal'] ?? '')) ?></td>
          <td><?= esc($p['skpd_id']) ?></td><td><?= esc($p['nama_paket']) ?></td><td><?= formatRupiah($p['pagu_anggaran'] ?? 0) ?></td>
          <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($pengajuan)): ?><tr><td colspan="7" class="text-center text-muted">Belum ada data laporan</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script>$(function(){$('#tabelLaporan').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true})});</script><?= $this->endSection() ?>
