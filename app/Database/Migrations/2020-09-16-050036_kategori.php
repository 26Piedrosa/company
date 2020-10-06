<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'kategori_id'	=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
				'auto_increment'	=> true,
			],
			'nama_kategori'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '100',
                'null'           	=> true,
			],
			'slug_kategori'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '150',
                'null'           	=> true,
			],
			'status_kategori' => [
				'type'				=> 'ENUM',
				'constraint'		=> ['Active', 'Inactive'],
				'default'			=> 'Active',
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
		$this->forge->addKey('kategori_id', true);
		$this->forge->createTable('kategori');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('kategori');
	}
}
