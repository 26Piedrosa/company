<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Hapus<?php echo $value['konten_id']; ?>">
  <i class="fas fa-trash"></i>
</button>

<div style="margin-top: 8%;" class="modal fade" id="Hapus<?php echo $value['konten_id']; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Hapus Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger text-left">
          Yakin ingin menghapus data konten <b><?php echo $value['judul_konten']; ?></b>?
        </div>
      </div>
      <div class="modal-footer float-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="<?php echo base_url('admin/konten/hapus/' . $value['konten_id']); ?>" class="btn btn-danger">
          <i class="fas fa-trash"></i> Ya, Hapus data ini
        </a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->