<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
	public function index()
	{
		$data = array(
			'title'	=> 'Halaman Dashboard'
		);
		return view('admin/dashboard/index', $data);
	}
}