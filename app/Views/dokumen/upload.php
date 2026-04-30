<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header"><h3 class="card-title">Ringkasan Pengajuan</h3></div>
  <div class="card-body">
    <p><strong><?= esc($pengajuan['nomor_pengajuan']) ?></strong> — <?= esc($pengajuan['nama_paket']) ?></p>
    <p class="text-muted mb-0">SKPD: <?= esc($skpd['nama_skpd'] ?? '-') ?> &middot; Status: <span class="badge text-bg-<?= statusClass($pengajuan['status']) ?>"><?= statusLabel($pengajuan['status']) ?></span></p>
  </div>
</div>

<div class="card">
  <div class="card-header"><h3 class="card-title">Upload Dokumen Baru</h3></div>
  <div class="card-body">
    <form action="<?= base_url("dokumen/upload/{$pengajuan['id']}") ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="row g-2">
        <div class="col-md-3"><input type="text" name="jenis_dokumen" class="form-control" placeholder="Jenis Dokumen" required></div>
        <div class="col-md-4"><input type="file" name="file_dokumen" class="form-control" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"></div>
        <div class="col-md-3"><input type="text" name="keterangan" class="form-control" placeholder="Keterangan"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Upload</button></div>
      </div>
    </form>
  </div>
</div>

<div class="callout callout-info">
  <h5><i class="fas fa-info-circle"></i> Aturan Upload</h5>
  <ul class="mb-0"><li>Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</li><li>Maks 10 MB per file</li><li>Semua dokumen akan diverifikasi oleh petugas</li></ul>
</div>

<div class="card">
  <div class="card-header"><h3 class="card-title">Dokumen Terupload</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-light"><tr><th>No</th><th>Jenis</th><th>Nama File</th><th>Ukuran</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($dokumen as $d): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= esc($d['jenis_dokumen']) ?></td><td><?= esc($d['nama_asli']) ?></td>
          <td><?= round($d['ukuran']/1024,1) ?> KB</td>
          <td><span class="badge text-bg-<?= statusClass($d['status_verifikasi']) ?>"><?= statusLabelDokumen($d['status_verifikasi']) ?></span></td>
          <td><?= esc($d['catatan'] ?? '-') ?></td>
          <td>
            <a href="<?= base_url("dokumen/{$d['id']}/download") ?>" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
            <?php if (in_array($pengajuan['status'], ['draft', 'perlu_perbaikan'])): ?>
            <button class="btn btn-sm btn-danger btn-hapus" data-url="<?= base_url("dokumen/{$d['id']}") ?>" data-nama="<?= esc($d['nama_asli']) ?>"><i class="fas fa-trash"></i></button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($dokumen)): ?><tr><td colspan="7" class="text-center text-muted">Belum ada dokumen</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<a href="<?= base_url("pengajuan/{$pengajuan['id']}") ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Detail</a>
<?= $this->endSection() ?>
