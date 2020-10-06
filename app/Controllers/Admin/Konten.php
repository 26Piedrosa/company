<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\KontenModel;

class Konten extends BaseController
{
	public function __construct()
	{
		$this->kategoriModel	= new KategoriModel();
		$this->kontenModel		= new KontenModel();
	}

	// LISTING DATA KONTEN
	public function index()
	{
		$konten = $this->kontenModel->join('kategori', 'kategori.kategori_id = konten.kategori_id')->orderBy('konten_id', 'desc')->findAll();
		// dd($konten);

		$data = [
			'title'		=> 'Data Konten',
			'konten'	=> $konten
		];
		return view('admin/konten/index', $data);
	}

	// TAMBAH DATA KONTEN
	public function tambah()
	{
		// LISTING KATEGORI ACTIVE
		$kategori = $this->kategoriModel->where('status_kategori', 'Active')->findAll();

		// MEMBENTUK DATA LISTING KATEGORI MENJADI ARRAY
		$kategori = array_column($kategori, 'nama_kategori', 'kategori_id');

		// MEMBUAT RULES VALIDASI
		$validation = \Config\Services::validation();
		$validation = $this->validate([
			'kategori_id' => [
				'label'  => 'Kategori Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} belum dipilih'
				]
			],
			'judul_konten' => [
				'label'  => 'Judul Konten',
				'rules'  => 'required|is_unique[konten.judul_konten]',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} sudah digunakan, silahkan ganti dengan judul lain'
				]
			],
			'jenis_konten' => [
				'label'  => 'Jenis Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong'
				]
			],
			'slug_konten' => [
				'label'  => 'Slug Konten',
				'rules'  => 'required|is_unique[konten.slug_konten]',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} sudah digunakan, silahkan ganti dengan slug lain'
				]
			],
			'isi_konten' => [
				'label'  => 'Isi Konten',
				'rules'  => 'required|min_length[200]',
				'errors' => [
					'required'		=> '{field} tidak boleh kosong',
					'min_length'	=> '{field} minimal 200 karakter'
				]
			],
			'status_konten' => [
				'label'  => 'Status Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} belum di pilih'
				]
			]
		]);

		// MEMBUAT RULE VALIDASI UPLOAD
		if(!empty($_FILES['path_file']['name']))
		{
			$validation = $this->validate([
				'path_file' => [
					'label'  => 'Foto/ Gambar',
					'rules'  => 'uploaded[path_file]|max_size[path_file,2048]|ext_in[path_file,jpg,png,gif]',
					'errors' => [
						'uploaded'	=> '{field} tidak valid',
						'max_size'	=> 'Ukuran {field} maksimal 2MB',
						'ext_in'	=> 'Ekstensi {field} harus .jpg .png atau .gif '
					]
				]
			]);
		}

		// PROSES SUBMIT DIJALANKAN
		if($this->request->getMethod() === "post")
		{
			// PROSES VALIDASI
			if(!$validation)
			{
				// VALIDASI GAGAL, MENAMPILKAN FORM TAMBAH KONTEN DAN PESAN ERRORS
				$data = array(
					'title'		=> 'Tambah Konten',
					'errors'	=> $this->validator,
					'kategori'	=> $kategori
				);
				return view('admin/konten/tambah', $data);
			}
			else
			{
				// VALIDASI SUKSES
				// MENAMPUNG DATA FILE UPLOAD
				$file		= $this->request->getFile('path_file');

				// MEMBUAT NAMA BARU UNTUK FILE
				$fileName	= $file->getRandomName();
				
				// CEK VALIDITAS PROSES UPLOAD
				if($file->isValid() && ! $file->hasMoved())
				{
					// PROSES UPLOAD VALID
					// MENYIMPAN FILE UPLOAD
					$file->move(ROOTPATH.'public/uploads/konten/images/', $fileName);
					
					// INISIALISASI MANIPULASI GAMBAR
					$image = \Config\Services::image();

					// PROSES RESIZE DAN SIMPAN GAMBAR THUMBNAIL
					$image->withFile(ROOTPATH.'public/uploads/konten/images/' . $fileName)->resize(200, 100, true, 'height')->save(ROOTPATH.'/public/uploads/konten/images/thumbs/' . $fileName);

					// MENAMPUNG INPUT DATA FORM DAN DATA FILE UPLOAD
					$data = [
						'kategori_id'	=> $this->request->getPost('kategori_id'),
						'judul_konten'	=> $this->request->getPost('judul_konten'),
						'jenis_konten'	=> $this->request->getPost('jenis_konten'),
						'slug_konten'	=> url_title($this->request->getPost('judul_konten'), '-', TRUE),
						'isi_konten'	=> $this->request->getPost('isi_konten'),
						'path_file'		=> $fileName,
						'status_konten'	=> $this->request->getPost('status_konten'),
						'created_by'	=> NULL,
						'created_at'	=> $this->sTamp(),
					];

					// PROSES SIMPAN DATA KE DATABASE
					$this->kontenModel->insert($data);
					
					// MEMBUAT PESAN SUKSES 
					session()->setFlashdata('success', 'Data berhasil di simpan dengan foto/ gambar');

					// MENGALIHKAN KE HALAMAN KONTEN
					return redirect()->to(base_url('admin/konten'));
				}
				else
				{
					// MENAMPUNG INPUT DATA FORM TANPA DATA FILE UPLOAD
					$data = [
						'kategori_id'	=> $this->request->getPost('kategori_id'),
						'judul_konten'	=> $this->request->getPost('judul_konten'),
						'jenis_konten'	=> $this->request->getPost('jenis_konten'),
						'slug_konten'	=> url_title($this->request->getPost('judul_konten'), '-', TRUE),
						'isi_konten'	=> $this->request->getPost('isi_konten'),
						'status_konten'	=> $this->request->getPost('status_konten'),
						'created_by'	=> NULL,
						'created_at'	=> $this->sTamp(),
					];

					// PROSES SIMPAN DATA KE DATABASE
					$this->kontenModel->insert($data);

					// MEMBUAT PESAN SUKSES 
					session()->setFlashdata('success', 'Data berhasil di simpan tanpa foto/ gambar');

					// MENGALIHKAN KE HALAMAN KONTEN
					return redirect()->to(base_url('admin/konten'));
				}
			}
		}
		// FORM TAMBAH KONTEN
		$data = [
			'title'		=> 'Tambah Konten',
			'kategori'	=> $kategori
		];
		return view('admin/konten/tambah', $data);
	}

	// EDIT DATA KONTEN
	public function edit($konten_id = null)
	{
		// DETAIL KONTEN
		$konten = $this->kontenModel->join('kategori', 'kategori.kategori_id = konten.kategori_id')->find($konten_id);

		// LISTING KATEGORI ACTIVE
		$kategori = $this->kategoriModel->where('status_kategori', 'Active')->findAll();

		// MEMBENTUK DATA LISTING KATEGORI MENJADI ARRAY
		$kategori = array_column($kategori, 'nama_kategori', 'kategori_id');

		// MEMBUAT RULES VALIDASI
		$validation = \Config\Services::validation();
		$validation = $this->validate([
			'kategori_id' => [
				'label'  => 'Kategori Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} belum dipilih'
				]
			],
			'judul_konten' => [
				'label'  => 'Judul Konten',
				'rules'  => 'required|is_unique[konten.judul_konten,konten_id,'.$konten_id.']',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} sudah digunakan, silahkan ganti dengan judul lain'
				]
			],
			'jenis_konten' => [
				'label'  => 'Jenis Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong'
				]
			],
			'isi_konten' => [
				'label'  => 'Isi Konten',
				'rules'  => 'required|min_length[200]',
				'errors' => [
					'required'		=> '{field} tidak boleh kosong',
					'min_length'	=> '{field} minimal 200 karakter'
				]
			],
			'status_konten' => [
				'label'  => 'Status Konten',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} belum di pilih'
				]
			]
		]);

		// MEMBUAT RULE VALIDASI UPLOAD
		if(!empty($_FILES['path_file']['name']))
		{
			$validation = $this->validate([
				'path_file' => [
					'label'  => 'Foto/ Gambar',
					'rules'  => 'uploaded[path_file]|max_size[path_file,2048]|ext_in[path_file,jpg,png,gif]',
					'errors' => [
						'uploaded'	=> '{field} tidak valid',
						'max_size'	=> 'Ukuran {field} maksimal 2MB',
						'ext_in'	=> 'Ekstensi {field} harus .jpg .png atau .gif '
					]
				]
			]);
		}

		// PROSES SUBMIT DIJALANKAN
		if($this->request->getMethod() === "post")
		{
			// PROSES VALIDASI
			if(!$validation)
			{
				// VALIDASI GAGAL, MENAMPILKAN FORM EDIT KONTEN DAN PESAN ERRORS
				$data = array(
					'title'		=> 'Edit Konten',
					'errors'	=> $this->validator,
					'konten'	=> $konten,
					'kategori'	=> $kategori
				);
				return view('admin/konten/edit', $data);
			}
			else
			{
				// VALIDASI SUKSES
				// MENAMPUNG DATA FILE UPLOAD
				$file		= $this->request->getFile('path_file');

				// MEMBUAT NAMA BARU UNTUK FILE
				$fileName	= $file->getRandomName();
				
				// CEK VALIDITAS PROSES UPLOAD
				if($file->isValid() && ! $file->hasMoved())
				{
					// PROSES UPLOAD VALID
					// MENYIMPAN FILE UPLOAD
					$file->move(ROOTPATH.'public/uploads/konten/images/', $fileName);
					
					// INISIALISASI MANIPULASI GAMBAR
					$image = \Config\Services::image();

					// PROSES RESIZE DAN SIMPAN GAMBAR THUMBNAIL
					$image->withFile(ROOTPATH.'public/uploads/konten/images/' . $fileName)->resize(200, 100, true, 'height')->save(ROOTPATH.'/public/uploads/konten/images/thumbs/' . $fileName);

					// PROSES CEK DAN HAPUS FILE LAMA
					$oldFile = ROOTPATH.'public/uploads/konten/images/' . $konten['path_file'];

					if(file_exists($oldFile))
					{
						unlink(ROOTPATH.'public/uploads/konten/images/' . $konten['path_file']);
						unlink(ROOTPATH.'public/uploads/konten/images/thumbs/' . $konten['path_file']);
					}

					// MENAMPUNG INPUT DATA FORM DAN DATA FILE UPLOAD
					$data = [
						'kategori_id'	=> $this->request->getPost('kategori_id'),
						'judul_konten'	=> $this->request->getPost('judul_konten'),
						'jenis_konten'	=> $this->request->getPost('jenis_konten'),
						'slug_konten'	=> url_title($this->request->getPost('judul_konten'), '-', TRUE),
						'isi_konten'	=> $this->request->getPost('isi_konten'),
						'path_file'		=> $fileName,
						'status_konten'	=> $this->request->getPost('status_konten'),
						'updated_by'	=> NULL,
						'updated_at'	=> $this->sTamp(),
					];

					// PROSES UPDATE DATA KE DATABASE
					$this->kontenModel->update($konten_id, $data);
					
					// MEMBUAT PESAN SUKSES 
					session()->setFlashdata('success', 'Data berhasil di simpan dengan foto/ gambar');

					// MENGALIHKAN KE HALAMAN INDEX KATEGORI
					return redirect()->to(base_url('admin/konten'));
				}
				else
				{
					// MENAMPUNG INPUT DATA FORM TANPA DATA FILE UPLOAD
					$data = [
						'kategori_id'	=> $this->request->getPost('kategori_id'),
						'judul_konten'	=> $this->request->getPost('judul_konten'),
						'jenis_konten'	=> $this->request->getPost('jenis_konten'),
						'slug_konten'	=> url_title($this->request->getPost('judul_konten'), '-', TRUE),
						'isi_konten'	=> $this->request->getPost('isi_konten'),
						'status_konten'	=> $this->request->getPost('status_konten'),
						'updated_by'	=> NULL,
						'updated_at'	=> $this->sTamp(),
					];

					// PROSES UPDATE DATA KE DATABASE
					$this->kontenModel->update($konten_id, $data);

					// MEMBUAT PESAN SUKSES 
					session()->setFlashdata('success', 'Data berhasil di simpan tanpa foto/ gambar');

					// MENGALIHKAN KE HALAMAN INDEX KATEGORI
					return redirect()->to(base_url('admin/konten'));
				}
			}
		}
		// FORM EDIT KONTEN
		$data = [
			'title'		=> 'Edit Konten',
			'konten'	=> $konten,
			'kategori'	=> $kategori
		];
		return view('admin/konten/edit', $data);
	}

	// HAPUS KONTEN
	public function hapus($konten_id = null)
	{
		$konten = $this->kontenModel->find($konten_id);

		if(!empty($konten))
		{
			// PROSES CEK DAN HAPUS FILE
			// $oldFile = ROOTPATH.'public/uploads/konten/images/' . $konten['path_file'];

			// if(file_exists($oldFile))
			// {
			// 	unlink(ROOTPATH.'public/uploads/konten/images/' . $konten['path_file']);
			// 	unlink(ROOTPATH.'public/uploads/konten/images/thumbs/' . $konten['path_file']);
			// }

			// PROSES HAPUS DATA DI DATABASE
			$this->kontenModel->delete($konten['konten_id']);

			// MEMBUAT PESAN SUKSES
			session()->setFlashdata('success', 'Data berhasil di hapus');

			// MENGALIHKAN KE HALAMAN INDEX KATEGORI
			return redirect()->to(base_url('admin/konten'));
		}
		else
		{
			// MEMBUAT PESAN ERRORS HAPUS
			session()->setFlashdata('danger', 'Maaf, data tidak tersedia');

			// MENGALIHKAN KE HALAMAN INDEX KATEGORI
			return redirect()->to(base_url('admin/konten'));
		}
	}
}