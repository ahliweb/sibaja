<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h4 class="mb-1"><?= esc($pengajuan['nomor_pengajuan']) ?> — <?= esc($pengajuan['nama_paket']) ?></h4>
        <p class="text-muted mb-0">SKPD: <?= esc($skpd['nama_skpd'] ?? '-') ?> &middot; Tahun: <?= esc($pengajuan['tahun_anggaran_id'] ?? '-') ?></p>
      </div>
      <div><span class="badge text-bg-<?= statusClass($pengajuan['status']) ?> fs-6"><?= statusLabel($pengajuan['status']) ?></span></div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <!-- Ringkasan -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Informasi Pengajuan</h3></div>
      <div class="card-body">
        <table class="table table-sm">
          <tr><th width="180">Tanggal</th><td><?= date('d/m/Y', strtotime($pengajuan['tanggal'] ?? '')) ?></td></tr>
          <tr><th>Jenis Pengadaan</th><td><?= esc($pengajuan['jenis_nama'] ?? $pengajuan['jenis_id'] ?? '-') ?></td></tr>
          <tr><th>Metode Pengadaan</th><td><?= esc($pengajuan['metode_nama'] ?? $pengajuan['metode_id'] ?? '-') ?></td></tr>
          <tr><th>Pagu Anggaran</th><td><strong><?= formatRupiah($pengajuan['pagu_anggaran'] ?? 0) ?></strong></td></tr>
          <tr><th>Sumber Dana</th><td><?= esc($pengajuan['sumber_dana'] ?? '-') ?></td></tr>
          <tr><th>Lokasi</th><td><?= esc($pengajuan['lokasi'] ?? '-') ?></td></tr>
        </table>
      </div>
    </div>

    <!-- Uraian -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Uraian & Spesifikasi</h3></div>
      <div class="card-body">
        <h6>Uraian Kebutuhan</h6><p><?= nl2br(esc($pengajuan['uraian'] ?? '-')) ?></p>
        <h6>Spesifikasi</h6><p><?= nl2br(esc($pengajuan['spesifikasi'] ?? '-')) ?></p>
      </div>
    </div>

    <!-- Dokumen -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Dokumen Pendukung</h3></div>
      <div class="card-body table-responsive">
        <table class="table table-bordered">
          <thead class="table-light"><tr><th>No</th><th>Jenis Dokumen</th><th>Nama File</th><th>Ukuran</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr></thead>
          <tbody>
            <?php $no = 1; foreach ($dokumen as $d): ?>
            <tr>
              <td><?= $no++ ?></td><td><?= esc($d['jenis_dokumen']) ?></td>
              <td><?= esc($d['nama_asli']) ?></td><td><?= round($d['ukuran']/1024,1) ?> KB</td>
              <td><span class="badge text-bg-<?= statusClass($d['status_verifikasi']) ?>"><?= statusLabelDokumen($d['status_verifikasi']) ?></span></td>
              <td><?= esc($d['catatan'] ?? '-') ?></td>
              <td>
                <a href="<?= base_url("dokumen/{$d['id']}/download") ?>" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($dokumen)): ?><tr><td colspan="7" class="text-center text-muted">Belum ada dokumen</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <!-- Riwayat -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Riwayat Proses</h3></div>
      <div class="card-body">
        <div class="timeline">
          <?php foreach ($riwayat as $item): ?>
          <div class="time-label"><span class="text-bg-<?= statusClass($item['status_baru']) ?>"><?= date('d M Y', strtotime($item['created_at'])) ?></span></div>
          <div><i class="fas <?= statusIcon($item['status_baru']) ?> text-bg-<?= statusClass($item['status_baru']) ?>"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> <?= date('H:i', strtotime($item['created_at'])) ?></span>
              <h3 class="timeline-header"><?= statusLabel($item['status_baru']) ?></h3>
              <div class="timeline-body"><?= esc($item['catatan'] ?? '-') ?></div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php if (empty($riwayat)): ?><p class="text-muted">Belum ada riwayat</p><?php endif; ?>
          <div><i class="fas fa-clock bg-secondary"></i></div>
        </div>
      </div>
    </div>

    <!-- Aksi -->
    <div class="card">
      <div class="card-header"><h3 class="card-title">Aksi</h3></div>
      <div class="card-body d-grid gap-2">
        <?php if (session('role') === 'skpd' && in_array($pengajuan['status'], ['draft', 'perlu_perbaikan'])): ?>
        <a href="<?= base_url("pengajuan/edit/{$pengajuan['id']}") ?>" class="btn btn-warning w-100"><i class="fas fa-edit"></i> Edit Pengajuan</a>
        <a href="<?= base_url("dokumen/upload/{$pengajuan['id']}") ?>" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Upload Dokumen</a>
        <?php endif; ?>
        <?php if (session('role') === 'skpd' && $pengajuan['status'] === 'draft'): ?>
        <a href="<?= base_url("pengajuan/{$pengajuan['id']}/kirim") ?>" class="btn btn-success w-100" onclick="return confirm('Kirim pengajuan ini?')"><i class="fas fa-paper-plane"></i> Kirim Pengajuan</a>
        <?php endif; ?>
        <?php if (in_array(session('role'), ['admin', 'petugas'])): ?>
        <a href="<?= base_url("dokumen/upload/{$pengajuan['id']}") ?>" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Upload Dokumen</a>
        <a href="<?= base_url("pengajuan/{$pengajuan['id']}/update-status") ?>" class="btn btn-warning w-100"><i class="fas fa-edit"></i> Ubah Status</a>
        <?php endif; ?>
        <a href="<?= base_url(session('role') === 'skpd' ? 'pengajuan/my' : 'pengajuan') ?>" class="btn btn-secondary w-100"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
