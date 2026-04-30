<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card"><div class="card-header"><h3 class="card-title">Detail Tahun Anggaran</h3></div>
<div class="card-body">
<table class="table table-bordered">
<tr><th width="200">Tahun</th><td><?= esc($data['tahun'] ?? '-') ?></td></tr>
<tr><th>Status</th><td><span class="badge text-bg-<?= ($data['status'] ?? '') === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($data['status'] ?? '-') ?></span></td></tr>
</table>
</div>
<div class="card-footer"><a href="<?= base_url('tahun-anggaran') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a> <a href="<?= base_url("tahun-anggaran/edit/{$data['id']}") ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></div>
</div>
<?= $this->endSection() ?>
