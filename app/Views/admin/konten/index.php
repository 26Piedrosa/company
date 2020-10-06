<?php $this->extend('admin/layout/adminlte'); ?>

<?php $this->section('content'); ?>

<!-- Load DataTables CSS -->
<?php echo $this->include('admin/layout/datatables_css'); ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="<?php echo base_url('admin/konten/tambah'); ?>" class="btn btn-primary float-right">
					<i class="fas fa-plus"></i> Tambah
				</a>
			</div>
			<div class="card-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Gambar</th>
							<th>Judul</th>
							<th>Jenis/ Kategori</th>
							<th>Isi Konten</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($konten as $no => $value){ ?>
						<tr>
							<td width="1%"><?php echo $no + 1; ?></td>
							<td width="14%" class="text-center">
								<img width="84" class="img-responsive rounded-circle" src="<?php echo base_url('uploads/konten/images/thumbs/' . $value['path_file']); ?>" alt="<?php echo $value['judul_konten']; ?>">
							</td>
							<td><?php echo $value['judul_konten']; ?></td>
							<td><?php echo $value['jenis_konten'] . ' - ' . $value['nama_kategori']; ?></td>
							<td><?php echo character_limiter($value['isi_konten'], 100); ?></td>
							<td><?php echo $value['status_konten']; ?></td>
							<td>
								<a href="<?php echo base_url('admin/konten/edit/' . $value['konten_id']); ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
								<?php include('hapus.php'); ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Load DataTables JS -->
<?php echo $this->include('admin/layout/datatables_js'); ?>

<?php $this->endSection(); ?>