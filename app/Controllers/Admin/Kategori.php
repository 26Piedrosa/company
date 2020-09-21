<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\KategoriModel;
use App\Controllers\BaseController;

class Kategori extends BaseController 
{
	public function __construct()
	{
		$this->kategoriModel = new KategoriModel();
	}

	// LISTING KATEGORI
	public function index()
	{
		// MENGAMBIL SEMUA DATA KATEGORI
		$kategori = $this->kategoriModel->findAll();

		$data = array(
			'title'		=> 'Data Kategori',
			'kategori'	=> $kategori
		);
		return view('admin/kategori/index', $data);
	}

	// TAMBAH KATEGORI
	public function tambah()
	{
		// INISIALISASI PENGGUNAAN VALIDASI
		$validation =  \Config\Services::validation();

		// MEMBUAT RULES VALIDASI
		$validation = $this->validate([
			'nama_kategori' => [
				'label'  => 'Nama kategori',
				'rules'  => 'required|is_unique[kategori.nama_kategori]',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} sudah digunakan, silahkan ganti dengan nama kategori lain'
				]
			],
			'status_kategori' => [
				'label'  => 'Status kategori',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong'
				]
			]
		]);
		
		// MEMPROSES REQUEST KETIKA SUBMIT DI KLIK
		if ($this->request->getMethod() === 'post')
		{
			// PROSES VALIDASI
			if (!$validation)
			{
				// VALIDASI TIDAK TERPENUHI, FORM VIEW TAMBAH DITAMPILKAN BESERTA ERRORS VALIDASI
				$data = array(
					'title'		=> 'Tambah Kategori',
					'errors'	=> $this->validator
				);
				return view('admin/kategori/tambah', $data);
			}
			else
			{
				// VALIDASI SUKSES
				$data = [
					'nama_kategori'		=> $this->request->getPost('nama_kategori'),
					'slug_kategori'		=> url_title($this->request->getPost('nama_kategori'), '-', TRUE),
					'status_kategori'	=> $this->request->getPost('status_kategori')
				];

				// PROSES SIMPAN DATA KE DATABASE
				$this->kategoriModel->insert($data);

				// MEMBUAT PESAN SUKSES 
				session()->setFlashdata('success', 'Data berhasil di simpan');

				// MENGALIHKAN KE HALAMAN INDEX KATEGORI
				return redirect()->to(base_url('admin/kategori'));
			}
		}

		// MENAMPILKAN FORM VIEW TAMBAH
		$data = array(
			'title'		=> 'Tambah Kategori',
		);
		return view('admin/kategori/tambah', $data);
	}

	// EDIT KATEGORI
	public function edit($kategori_id=null)
	{
		// MENGAMBIL DATA KATEGORI BERDASARKAN PARAMETER $KATEGORI_ID
		$kategori = $this->kategoriModel->find($kategori_id);

		// INISIALISASI PENGGUNAAN VALIDASI
		$validation =  \Config\Services::validation();

		// MEMBUAT RULES VALIDASI
		$validation = $this->validate([
			'nama_kategori' => [
				'label'  => 'Nama kategori',
				'rules'  => 'required|is_unique[kategori.nama_kategori,kategori_id,'.$kategori_id.']',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong',
					'is_unique'	=> '{field} sudah digunakan, silahkan ganti dengan nama kategori lain'
				]
			],
			'status_kategori' => [
				'label'  => 'Status kategori',
				'rules'  => 'required',
				'errors' => [
					'required'	=> '{field} tidak boleh kosong'
				]
			]
		]);

		// dd($validation);
		
		// MEMPROSES REQUEST KETIKA SUBMIT DI KLIK
		if ($this->request->getMethod() === 'post')
		{
			// PROSES VALIDASI
			if (!$validation)
			{
				// VALIDASI TIDAK TERPENUHI, FORM VIEW EDIT DITAMPILKAN BESERTA ERRORS VALIDASI
				$data = array(
					'title'		=> 'Edit Kategori',
					'kategori'	=> $kategori,
					'errors'	=> $this->validator
				);
				return view('admin/kategori/edit', $data);
			}
			else
			{
				// VALIDASI SUKSES
				$data = [
					'nama_kategori'		=> $this->request->getPost('nama_kategori'),
					'slug_kategori'		=> url_title($this->request->getPost('nama_kategori'), '-', TRUE),
					'status_kategori'	=> $this->request->getPost('status_kategori')
				];

				// PROSES UPDATE DATA KE DATABASE
				$this->kategoriModel->update($kategori_id, $data);

				// MEMBUAT PESAN SUKSES
				session()->setFlashdata('success', 'Data berhasil di simpan');

				// MENGALIHKAN KE HALAMAN INDEX KATEGORI
				return redirect()->to(base_url('admin/kategori'));
			}
		}

		// MENAMPILKAN FORM VIEW EDIT
		$data = array(
			'title'		=> 'Edit Kategori',
			'kategori'	=> $kategori
		);
		return view('admin/kategori/edit', $data);
	}

	// HAPUS KATEGORI
	public function hapus($kategori_id=null)
	{
		$kategori = $this->kategoriModel->find($kategori_id);

		if(!empty($kategori))
		{
			// PROSES HAPUS DATA DI DATABASE
			$this->kategoriModel->delete($kategori_id);

			// MEMBUAT PESAN SUKSES
			session()->setFlashdata('success', 'Data berhasil di hapus');

			// MENGALIHKAN KE HALAMAN INDEX KATEGORI
			return redirect()->to(base_url('admin/kategori'));
		}
		else
		{
			// MEMBUAT PESAN ERRORS HAPUS
			session()->setFlashdata('danger', 'Maaf, data tidak tersedia');

			// MENGALIHKAN KE HALAMAN INDEX KATEGORI
			return redirect()->to(base_url('admin/kategori'));
		}
	}
}