<?php $this->extend('admin/layout/adminlte'); ?>

<?php $this->section('content'); ?>

<!-- Load css datatables -->
<?php echo $this->include('admin/layout/datatables_css') ?>

<!-- Main row -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="float-right">
          <a href="<?php echo base_url('admin/kategori/tambah'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="55%">Nama</th>
              <th width="20%">Status</th>
              <th width="20%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($kategori as $kategori){ ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $kategori['nama_kategori']; ?></td>
              <td><?php echo $kategori['status_kategori']; ?></td>
              <td class="text-center">
                <a href="<?php echo base_url('admin/kategori/edit/' . $kategori['kategori_id']); ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                <?php include('hapus.php'); ?>
              </td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>
      </div><!-- /.card-body -->
    </div>
  </div>
</div>
<!-- /.row (main row) -->

<!-- Load js datatables -->
<?php echo $this->include('admin/layout/datatables_js') ?>

<?php $this->endSection(); ?>