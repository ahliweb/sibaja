<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title"><?= $title ?></h3>
    <div class="card-tools">
      <a href="<?= base_url('laporan') ?>" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Export</a>
    </div>
  </div>
  <div class="card-body">
    <div class="row mb-3 g-2">
      <div class="col-md-2 col-sm-4">
        <select class="form-select form-select-sm filter-select" data-column="4">
          <option value="">Status</option>
          <option value="Draft">Draft</option><option value="Diajukan">Diajukan</option><option value="Diverifikasi">Diverifikasi</option>
          <option value="Dalam Proses">Dalam Proses</option><option value="Selesai">Selesai</option>
          <option value="Perlu Perbaikan">Perlu Perbaikan</option><option value="Ditolak">Ditolak</option>
        </select>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover dataTable" id="tabelPengajuan">
        <thead class="table-light"><tr><th>No</th><th>Nomor</th><th>Tgl</th><th>SKPD</th><th>Nama Paket</th><th>Jenis</th><th>Pagu</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php $no = 1; foreach ($pengajuan as $p): ?>
          <tr>
            <td><?= $no++ ?></td><td><?= esc($p['nomor_pengajuan'] ?? '-') ?></td><td><?= date('d/m/Y', strtotime($p['tanggal'] ?? '')) ?></td>
            <td><?= esc($p['skpd_id']) ?></td><td><?= esc($p['nama_paket']) ?></td><td><?= esc($p['jenis_id']) ?></td>
            <td><?= formatRupiah($p['pagu_anggaran'] ?? 0) ?></td>
            <td><span class="badge text-bg-<?= statusClass($p['status']) ?>"><?= statusLabel($p['status']) ?></span></td>
            <td nowrap>
              <a href="<?= base_url("pengajuan/{$p['id']}") ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
              <?php if ($this->isAdmin() || $this->isPetugas()): ?>
              <a href="<?= base_url("pengajuan/{$p['id']}/update-status") ?>" class="btn btn-sm btn-warning" title="Ubah Status"><i class="fas fa-edit"></i></a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>$(function(){var t=$('#tabelPengajuan').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true,pageLength:25,columnDefs:[{targets:-1,orderable:false}]});$('.filter-select').on('change',function(){t.column($(this).data('column')).search($(this).val()).draw()})});</script>
<?= $this->endSection() ?>
