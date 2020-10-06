<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Konten extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->addField([
			'konten_id'	=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
				'auto_increment'	=> true,
			],
			'kategori_id'	=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
                'null'           	=> true,
			],
			'judul_konten'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '200',
                'null'           	=> true,
			],
			'jenis_konten' => [
				'type'				=> 'ENUM',
				'constraint'		=> ['Blog', 'News'],
				'default'			=> 'Blog',
				'null'				=> false,
			],
			'slug_konten'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
                'null'           	=> true,
			],
			'isi_konten'	=> [
				'type'				=> 'TEXT',
                'null'           	=> true,
			],
			'path_file'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
                'null'           	=> true,
			],
			'status_konten' => [
				'type'				=> 'ENUM',
				'constraint'		=> ['Published', 'Draft'],
				'default'			=> 'Published',
				'null'				=> false,
			],
			'created_by'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
                'null'           	=> true,
			],
			'updated_by'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
                'null'           	=> true,
			],
			'deleted_by'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
                'null'           	=> true,
			],
			'created_at'	=> [
				'type'				=> 'DATETIME',
                'null'           	=> true,
			],
			'updated_at'	=> [
				'type'				=> 'DATETIME',
                'null'           	=> true,
			],
			'deleted_at'	=> [
				'type'				=> 'DATETIME',
                'null'           	=> true,
			],
		]);
		$this->forge->addKey('konten_id', true);
		$this->forge->addForeignKey('kategori_id','kategori','kategori_id');
		$this->forge->createTable('konten');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('konten');
	}
}
