<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login();
	}
	
	public function index()
	{
		$data = array(
			'title'	=> 'Dashboard',
			'css'	=> array(),
			'js'	=> array()
		);
							
		$this->load->view('admin/template/header', $data);
		$this->load->view('admin/dashboard_view');
		$this->load->view('admin/template/footer');
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */