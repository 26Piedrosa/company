<?php $this->extend('admin/layout/adminlte'); ?>

<?php $this->section('content'); ?>
<!-- Main row -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <?php echo form_open('admin/kategori/tambah'); ?>
        <div class="form-group">
          <label for="nama_katgori">Nama Kategori</label>
          <?php echo form_input('nama_kategori', esc(set_value('nama_kategori')), 'class="form-control" placeholder="Nama kategori"'); ?>
          <?php if(!empty($errors)){ ?>
            <em class="text-danger"><?php echo $errors->getError('nama_kategori') ?></em>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="status_kategori">Status</label>
          <?php echo form_dropdown('status_kategori', ['Active' => 'Active', 'Inactive' => 'Inactive'], '', 'class="form-control"'); ?>
        </div>
        <div class="form-group">
          <button type="submit" name="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan
          </button>
        </div>
        <?php echo form_close(); ?>
      </div><!-- /.card-body -->
    </div>
  </div>
</div>
<!-- /.row (main row) -->
<?php $this->endSection(); ?>