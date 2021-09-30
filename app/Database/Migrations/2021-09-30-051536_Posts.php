<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'posts_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'judul'       => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'deskripsi' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'gambar'       => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
			],
			'author'       => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'kategori'       => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'slug'       => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'unique'	 => 'true',
			],
			'created at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('posts_id', true);
		$this->forge->createTable('posts');
	}

	public function down()
	{
		$this->forge->dropTable('posts');
	}
}
