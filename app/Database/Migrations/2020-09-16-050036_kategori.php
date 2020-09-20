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
			],
			'slug_kategori'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
			],
			'status_kategori' => [
				'type'				=> 'ENUM("Aktif", "Nonaktif")',
				'default'			=> 'Aktif',
				'null'				=> false,
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
