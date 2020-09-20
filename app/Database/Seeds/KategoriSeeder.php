<?php namespace App\Database\Seeds;

class KategoriSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		$data = [
			'nama_kategori' => 'Blog',
			'slug_kategori'	=> 'blog'
		];

		// Using Query Builder
		$this->db->table('kategori')->insert($data);
	}
}