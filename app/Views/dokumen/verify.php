<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline">
  <div class="card-header"><h3 class="card-title">Verifikasi Dokumen</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped dataTable" id="tabelDokumen">
      <thead class="table-light"><tr><th>No</th><th>Jenis</th><th>Nama File</th><th>Ukuran</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($dokumen as $d): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= esc($d['jenis_dokumen']) ?></td><td><?= esc($d['nama_asli']) ?></td>
          <td><?= round($d['ukuran']/1024,1) ?> KB</td>
          <td><span class="badge text-bg-<?= statusClass($d['status_verifikasi']) ?>"><?= statusLabelDokumen($d['status_verifikasi']) ?></span></td>
          <td><?= esc($d['catatan'] ?? '-') ?></td>
          <td nowrap>
            <a href="<?= base_url("dokumen/{$d['id']}/download") ?>" class="btn btn-sm btn-info"><i class="fas fa-download"></i></a>
            <button class="btn btn-sm btn-success btn-verify" data-id="<?= $d['id'] ?>" data-status="lengkap"><i class="fas fa-check"></i></button>
            <button class="btn btn-sm btn-warning btn-verify" data-id="<?= $d['id'] ?>" data-status="perlu_perbaikan"><i class="fas fa-exclamation-triangle"></i></button>
            <button class="btn btn-sm btn-danger btn-verify" data-id="<?= $d['id'] ?>" data-status="ditolak"><i class="fas fa-times"></i></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modalVerify" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form id="formVerify" method="post">
      <?= csrf_field() ?>
      <div class="modal-header"><h5 class="modal-title">Verifikasi Dokumen</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label>Status Verifikasi</label><input type="text" id="vStatus" class="form-control" readonly></div>
        <div class="mb-3"><label>Catatan</label><textarea name="catatan" id="vCatatan" class="form-control" rows="3"></textarea></div>
        <input type="hidden" name="status_verifikasi" id="vStatusVal">
      </div>
      <div class="modal-footer"><button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button></div>
    </form>
  </div></div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(function(){$('#tabelDokumen').DataTable({language:{url:'//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'},responsive:true});
$('.btn-verify').on('click',function(){var id=$(this).data('id');var s=$(this).data('status');
$('#vStatus').val(s==='lengkap'?'Lengkap':(s==='perlu_perbaikan'?'Perlu Perbaikan':'Ditolak'));
$('#vStatusVal').val(s);$('#vCatatan').prop('required',s!=='lengkap').val('');
$('#formVerify').attr('action','<?= base_url('dokumen') ?>/'+id+'/verify');$('#modalVerify').modal('show')})});
</script>
<?= $this->endSection() ?>
