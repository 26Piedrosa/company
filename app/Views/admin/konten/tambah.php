<?php $this->extend('admin/layout/adminlte'); ?>

<?php $this->section('content'); ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<?php echo form_open_multipart('admin/konten/tambah'); ?>
				<div class="form-group">
					<label for="judul_konten">Judul Konten</label>
					<input type="text" name="judul_konten" class="form-control" value="<?php echo set_value('judul_konten'); ?>" placeholder="Judul konten">
					<?php if(!empty($errors)){ ?>
						<em class="text-danger"><?php echo $errors->getError('judul_konten'); ?></em>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="jenis_konten">Jenis Konten</label>
							<select name="jenis_konten" class="form-control">
								<option value="Blog">Blog</option>
								<option value="News">News</option>
							</select>
							<?php if(!empty($errors)){ ?>
								<em class="text-danger"><?php echo $errors->getError('jenis_konten'); ?></em>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="kategori_id">Kategori Konten</label>
							<?php echo form_dropdown('kategori_id', $kategori, '', 'class="form-control"'); ?>
							<?php if(!empty($errors)){ ?>
								<em class="text-danger"><?php echo $errors->getError('kategori_id'); ?></em>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="path_file">Upload Foto/ Gambar</label>
					<input type="file" name="path_file" class="form-control">
					<?php if(!empty($errors)){ ?>
						<em class="text-danger"><?php echo $errors->getError('path_file'); ?></em>
					<?php } ?>
				</div>

				<div class="form-group">
					<label for="isi_konten">Isi Konten</label>
					<textarea name="isi_konten" class="form-control" rows="6" placeholder="Isi konten"><?php echo esc(set_value('isi_konten')); ?></textarea>
					<?php if(!empty($errors)){ ?>
						<em class="text-danger"><?php echo $errors->getError('isi_konten'); ?></em>
					<?php } ?>
				</div>
				<div class="form-group">
					<label for="status_konten">Status</label>
					<select name="status_konten" class="form-control">
						<option value="Draft">Draft</option>
						<option value="Published">Published</option>
					</select>
					<?php if(!empty($errors)){ ?>
						<em class="text-danger"><?php echo $errors->getError('status_konten'); ?></em>
					<?php } ?>
				</div>
				<div class="form-group">
					<div class="float-right">
						<button type="submit" name="submit" class="btn btn-success">
							<i class="fas fa-save"></i> Simpan
						</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php $this->endSection(); ?>