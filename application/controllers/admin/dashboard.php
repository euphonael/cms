<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'Dashboard',
			'css'	=> array(),
			'js'	=> array()
		);

		$this->show('admin/dashboard_view', $data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */