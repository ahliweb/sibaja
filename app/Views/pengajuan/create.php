<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> Pengajuan</h3></div>
  <form action="<?= base_url($isEdit ? "pengajuan/{$data['id']}/update" : 'pengajuan/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">

      <h5 class="text-primary">A. Informasi Pengajuan</h5>
      <?php if ($isEdit): ?>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Nomor Pengajuan</label><div class="col-sm-9"><input type="text" class="form-control" value="<?= esc($data['nomor_pengajuan'] ?? '-') ?>" readonly></div></div>
      <?php endif; ?>
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Tahun Anggaran <span class="text-danger">*</span></label>
        <div class="col-sm-9"><select name="tahun_anggaran_id" class="form-select" required>
          <option value="">Pilih Tahun</option>
          <?php foreach ($tahunList as $t): ?>
          <option value="<?= $t['id'] ?>" <?= old('tahun_anggaran_id', $data['tahun_anggaran_id'] ?? '') == $t['id'] ? 'selected' : '' ?>><?= $t['tahun'] ?></option>
          <?php endforeach; ?>
        </select></div>
      </div>

      <hr>
      <h5 class="text-primary">B. Informasi Paket</h5>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Nama Paket <span class="text-danger">*</span></label><div class="col-sm-9"><input type="text" name="nama_paket" class="form-control" value="<?= old('nama_paket', $data['nama_paket'] ?? '') ?>" required></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Jenis Pengadaan <span class="text-danger">*</span></label><div class="col-sm-9"><select name="jenis_id" class="form-select" required>
        <option value="">Pilih Jenis</option>
        <?php foreach ($jenisList as $j): ?><option value="<?= $j['id'] ?>" <?= old('jenis_id', $data['jenis_id'] ?? '') == $j['id'] ? 'selected' : '' ?>><?= esc($j['nama']) ?></option><?php endforeach; ?>
      </select></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Metode Pengadaan <span class="text-danger">*</span></label><div class="col-sm-9"><select name="metode_id" class="form-select" required>
        <option value="">Pilih Metode</option>
        <?php foreach ($metodeList as $m): ?><option value="<?= $m['id'] ?>" <?= old('metode_id', $data['metode_id'] ?? '') == $m['id'] ? 'selected' : '' ?>><?= esc($m['nama']) ?></option><?php endforeach; ?>
      </select></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Pagu Anggaran <span class="text-danger">*</span></label><div class="col-sm-9"><input type="text" name="pagu_anggaran" id="pagu_anggaran" class="form-control" value="<?= old('pagu_anggaran', $data['pagu_anggaran'] ?? '') ?>" required></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Sumber Dana <span class="text-danger">*</span></label><div class="col-sm-9"><input type="text" name="sumber_dana" class="form-control" value="<?= old('sumber_dana', $data['sumber_dana'] ?? '') ?>" required></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Lokasi</label><div class="col-sm-9"><input type="text" name="lokasi" class="form-control" value="<?= old('lokasi', $data['lokasi'] ?? '') ?>"></div></div>

      <hr>
      <h5 class="text-primary">C. Uraian dan Spesifikasi</h5>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Uraian <span class="text-danger">*</span></label><div class="col-sm-9"><textarea name="uraian" class="form-control" rows="4" required><?= old('uraian', $data['uraian'] ?? '') ?></textarea></div></div>
      <div class="mb-3 row"><label class="col-sm-3 col-form-label">Spesifikasi</label><div class="col-sm-9"><textarea name="spesifikasi" class="form-control" rows="3"><?= old('spesifikasi', $data['spesifikasi'] ?? '') ?></textarea></div></div>

      <input type="hidden" name="status" id="statusPengajuan" value="<?= $data['status'] ?? 'draft' ?>">
    </div>
    <div class="card-footer d-flex justify-content-between">
      <div>
        <button type="submit" class="btn btn-secondary" onclick="$('#statusPengajuan').val('draft')">
          <i class="fas fa-save"></i> Simpan Draft
        </button>
        <button type="submit" class="btn btn-success" onclick="$('#statusPengajuan').val('diajukan')">
          <i class="fas fa-paper-plane"></i> Kirim Pengajuan
        </button>
      </div>
      <a href="<?= base_url($isEdit ? "pengajuan/{$data['id']}" : 'pengajuan/my') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-times"></i> Batal
      </a>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$('#pagu_anggaran').on('input',function(){var v=$(this).val().replace(/[^0-9]/g,'');$(this).val(v.replace(/\B(?=(\d{3})+(?!\d))/g,'.'))});
</script>
<?= $this->endSection() ?>
