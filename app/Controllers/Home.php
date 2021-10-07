<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{

		return view('welcome_message');
	}

	public function show()
	{
		$adat['nama'] = 'Muhammad Irfan Ardiansyah';
		$adat['jurusan'] = 'Ilmu Komputer';
		echo view("mahasiswa/index", $adat);
		echo view("mahasiswa/header");
		echo view("mahasiswa/footer");
	}
}
