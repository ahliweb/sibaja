<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cetak Laporan — SIBAJA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { background: #fff; }
      .card { box-shadow: none; border: 1px solid #ddd; }
    }
    .header-print { text-align:center; margin-bottom:20px; }
    .header-print h3 { margin:0; }
  </style>
</head>
<body>
<div class="container-fluid p-4">
  <div class="header-print">
    <h3>LAPORAN PENGAJUAN BARANG/JASA</h3>
    <p class="text-muted">SIBAJA — Sekretariat Daerah Kabupaten Kotawaringin Barat</p>
    <p>Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
  </div>

  <div class="row mb-3">
    <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= count($pengajuan) ?></h3><p>Total</p></div></div></div>
    <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3><?= $countSelesai ?></h3><p>Selesai</p></div></div></div>
    <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= $countProses ?></h3><p>Proses</p></div></div></div>
    <div class="col-lg-3 col-6"><div class="small-box bg-primary"><div class="inner"><h3><?= formatRupiah($totalPagu) ?></h3><p>Total Pagu</p></div></div></div>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped" width="100%">
        <thead class="table-light"><tr><th>No</th><th>Nomor</th><th>Tgl</th><th>SKPD</th><th>Nama Paket</th><th>Pagu</th><th>Status</th></tr></thead>
        <tbody>
          <?php $no = 1; foreach ($pengajuan as $p): ?>
          <tr><td><?= $no++ ?></td><td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td><td><?= date('d/m/Y', strtotime($p['tanggal'] ?? '')) ?></td>
            <td><?= esc($p['nama_skpd'] ?? $p['skpd_id'] ?? '-') ?></td><td><?= esc($p['nama_paket']) ?></td><td><?= formatRupiah($p['pagu_anggaran'] ?? 0) ?></td>
            <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="no-print text-center mt-3">
    <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
    <a href="<?= base_url('laporan') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>
</body>
</html>
