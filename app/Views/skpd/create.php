<?= $this->extend('layouts/adminlte') ?>

<?= $this->section('content') ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $isEdit ? 'Edit' : 'Tambah' ?> SKPD</h3></div>
  <form action="<?= base_url($isEdit ? "skpd/update/{$data['id']}" : 'skpd') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body">
      <div class="mb-3 row">
        <label for="kode_skpd" class="col-sm-3 col-form-label">Kode SKPD <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" name="kode_skpd" id="kode_skpd" class="form-control <?= isset($errors['kode_skpd']) ? 'is-invalid' : '' ?>" value="<?= old('kode_skpd', $data['kode_skpd'] ?? '') ?>" required>
          <div class="invalid-feedback"><?= $errors['kode_skpd'] ?? '' ?></div>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="nama_skpd" class="col-sm-3 col-form-label">Nama SKPD <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" name="nama_skpd" id="nama_skpd" class="form-control <?= isset($errors['nama_skpd']) ? 'is-invalid' : '' ?>" value="<?= old('nama_skpd', $data['nama_skpd'] ?? '') ?>" required>
          <div class="invalid-feedback"><?= $errors['nama_skpd'] ?? '' ?></div>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="kepala_skpd" class="col-sm-3 col-form-label">Kepala SKPD</label>
        <div class="col-sm-9"><input type="text" name="kepala_skpd" id="kepala_skpd" class="form-control" value="<?= old('kepala_skpd', $data['kepala_skpd'] ?? '') ?>"></div>
      </div>
      <div class="mb-3 row">
        <label for="nip_kepala" class="col-sm-3 col-form-label">NIP Kepala</label>
        <div class="col-sm-9"><input type="text" name="nip_kepala" id="nip_kepala" class="form-control" value="<?= old('nip_kepala', $data['nip_kepala'] ?? '') ?>"></div>
      </div>
      <div class="mb-3 row">
        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9"><textarea name="alamat" id="alamat" class="form-control" rows="2"><?= old('alamat', $data['alamat'] ?? '') ?></textarea></div>
      </div>
      <div class="mb-3 row">
        <label for="kontak" class="col-sm-3 col-form-label">Kontak</label>
        <div class="col-sm-9"><input type="text" name="kontak" id="kontak" class="form-control" value="<?= old('kontak', $data['kontak'] ?? '') ?>"></div>
      </div>
      <div class="mb-3 row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9"><input type="email" name="email" id="email" class="form-control" value="<?= old('email', $data['email'] ?? '') ?>"></div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
      <a href="<?= base_url('skpd') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
