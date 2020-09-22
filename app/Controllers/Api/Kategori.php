<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController 
{
	protected $modelName	= 'App\Models\KategoriModel';
	protected $format		= 'json';

	// LISTING KATEGORI
	public function index()
	{
		// MENGAMBIL SEMUA DATA KATEGORI
		$kategori = $this->respond($this->model->findAll(), 200);
		// dd($kategori);

		return $kategori;
	}

	// TAMBAH KATEGORI
	public function create()
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
		
		// MEMPROSES REQUEST POST
		if ($this->request->getMethod() === 'post')
		{
			// PROSES VALIDASI
			if (!$validation)
			{
				// VALIDASI TIDAK TERPENUHI, MENGIRIM PESAN ERRORS VALIDASI
				$errors = [$this->validator->getErrors()];
				return $this->fail($errors, 400);
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
				$this->model->insert($data);

				$success = ['success' => 'Data berhasil di tambah'];
				$response = [
					'status'	=> 201 ,
					'code'		=> '201',
					'message'	=> $success
				];
				return $this->respond($response, 201);
			}
		}
	}

	// DETAIL KATEGORI
	public function show($kategori_id = null)
	{
		// MENGAMBIL DATA KATEGORI BERDASARKAN PARAMETER $KATEGORI_ID
		if($kategori_id != null)
		{
			$kategori = $this->model->find($kategori_id);

			if(!empty($kategori))
			{
				return $this->respond($kategori, 200);
			}
			else
			{
				$errors = ['error' => 'Data tidak di temukan'];
				$response = [
					'status'	=> 404 ,
					'code'		=> '404',
					'message'	=> $errors
				];
				return $this->respond($response, 404);
			}
		}
		else
		{
			// RESPONSE ERRORS DATA NOT FOUND
			$errors = ['error' => 'Data tidak di temukan'];
			$response = [
				'status'	=> 404 ,
				'code'		=> '404',
				'message'	=> $errors
			];
			return $this->respond($response, 404);
		}
	}

	// EDIT KATEGORI
	public function update($kategori_id = null)
	{
		// MENGAMBIL DATA KATEGORI BERDASARKAN PARAMETER $KATEGORI_ID
		if($kategori_id != null)
		{
			$kategori = $this->model->find($kategori_id);
		}
		
		if(!empty($kategori))
		{
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
			if ($this->request->getMethod() === 'put')
			{
				// PROSES VALIDASI
				if (!$validation)
				{
					// VALIDASI TIDAK TERPENUHI, RESPONSE ERRORS VALIDATION
					$errors = [$this->validator->getErrors()];
					return $this->fail($errors, 400);
				}
				else
				{
					// VALIDASI SUKSES
					$data = $this->request->getRawInput();
					$data['slug_kategori'] = url_title($data['nama_kategori'], '-', TRUE);

					// PROSES UPDATE DATA KE DATABASE
					$this->model->update($kategori_id, $data);

					// RESPONSE SUCCESS UPDATE DATA
					$success = ['success' => 'Data berhasil di ubah'];
					$response = [
						'status'	=> 200 ,
						'code'		=> '200',
						'message'	=> $success
					];
					return $this->respond($response, 200);
				}
			}

			// GET DATA
			$response = [
				'status'	=> 200 ,
				'code'		=> '200',
				'data'		=> $kategori
			];
			return $this->respond($response, 201);
		}
		else
		{
			// RESPONSE ERRORS DATA NOT FOUND
			$errors = ['error' => 'Data tidak di temukan'];
			$response = [
				'status'	=> 404 ,
				'code'		=> '404',
				'message'	=> $errors
			];
			return $this->respond($response, 404);
		}
	}

	// HAPUS KATEGORI
	public function delete($kategori_id = null)
	{
		if($kategori_id != null)
		{
			$kategori = $this->model->find($kategori_id);
		}

		if(!empty($kategori))
		{
			// PROSES HAPUS DATA DI DATABASE
			$this->model->delete($kategori_id);

			$success = ['success' => 'Data berhasil di hapus'];
			$response = [
				'status'	=> 200 ,
				'code'		=> '200',
				'message'	=> $success
			];
			return $this->respond($response, 200);
		}
		else
		{
			$errors = ['error' => 'Data tidak di temukan'];
			$response = [
				'status'	=> 404 ,
				'code'		=> '404',
				'message'	=> $errors
			];
			return $this->respond($response, 404);
		}
	}
}