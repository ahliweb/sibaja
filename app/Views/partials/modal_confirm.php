<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmLabel">Konfirmasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Batal
        </button>
        <a href="#" id="btnConfirmDelete" class="btn btn-danger">
          <i class="fas fa-trash"></i> Hapus
        </a>
      </div>
    </div>
  </div>
</div>

<script>
$(function () {
  $('.btn-hapus').on('click', function () {
    const url = $(this).data('url');
    const nama = $(this).data('nama');
    $('#modalConfirm').find('.modal-body').html(
      'Apakah Anda yakin ingin menghapus <strong>' + nama + '</strong>?'
    );
    $('#modalConfirm').find('#btnConfirmDelete').attr('href', url);
    $('#modalConfirm').modal('show');
  });
});
</script>
