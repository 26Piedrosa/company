<?php namespace App\Models;

use CodeIgniter\Model;

class KontenModel extends Model
{
    protected $table      = 'konten';
    protected $primaryKey = 'konten_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['kategori_id', 'judul_konten', 'jenis_konten', 'slug_konten', 'isi_konten', 'path_file', 'status_konten', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation   = false;

    // public function listing()
    // {
    // 	$builder = $this->table('konten');
    // 	$builder->select('*');
    // 	$builder->join('kategori', 'kategori.kategori_id = konten.kategori_id');
    // 	$builder->orderBy('konten_id', 'desc');

    // 	$query = $builder->get();
    // 	return $query->getResultArray();
    // }

    // public function detail($konten_id='')
    // {
    // 	$builder = $this->table('konten');
    // 	$builder->select('*');
    // 	$builder->join('kategori', 'kategori.kategori_id = konten.kategori_id');
    // 	$builder->where('konten_id', $konten_id);
    // 	$builder->orderBy('konten_id', 'desc');

    // 	$query = $builder->get();
    // 	return $query->getRowArray();
    // }
}