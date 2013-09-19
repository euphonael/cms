<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_ajax');
	}	
	
	public function toggle_status()
	{
		$this->model_ajax->toggle_status();
	}
	
	public function delete_row()
	{
		$this->model_ajax->delete_row();
	}
}


/* End of file ajax.php */
/* Location: ./application/controllers/admin/ajax.php */