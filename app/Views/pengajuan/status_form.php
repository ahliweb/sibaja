<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title">Ubah Status Pengajuan</h3></div>
  <form action="<?= base_url("pengajuan/{$pengajuan['id']}/update-status") ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3"><label>Nomor Pengajuan</label><input type="text" class="form-control" value="<?= esc($pengajuan['nomor_pengajuan']) ?>" readonly></div>
      <div class="mb-3"><label>Nama Paket</label><input type="text" class="form-control" value="<?= esc($pengajuan['nama_paket']) ?>" readonly></div>
      <div class="mb-3"><label>Status Saat Ini</label>
        <span class="badge text-bg-<?= statusClass($pengajuan['status']) ?> ms-2"><?= statusLabel($pengajuan['status']) ?></span>
      </div>
      <div class="mb-3">
        <label>Status Baru <span class="text-danger">*</span></label>
        <select name="status_baru" class="form-select" required id="statusBaru">
          <option value="">Pilih Status Baru</option>
          <option value="diverifikasi">Diverifikasi</option>
          <option value="perlu_perbaikan">Perlu Perbaikan</option>
          <option value="dalam_proses">Dalam Proses</option>
          <option value="selesai">Selesai</option>
          <option value="ditolak">Ditolak</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Catatan <span id="catatanWajib" class="text-danger d-none">* wajib</span></label>
        <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Status</button>
      <a href="<?= base_url("pengajuan/{$pengajuan['id']}") ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$('#statusBaru').on('change',function(){var v=$(this).val();var w=v==='perlu_perbaikan'||v==='ditolak';$('#catatanWajib').toggleClass('d-none',!w);$('#catatan').prop('required',w)});
</script>
<?= $this->endSection() ?>
