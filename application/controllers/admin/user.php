<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	var $title = 'User';
	var $url = 'user';
	var $db_table = 'admin';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('jquery.dataTables'),
			'js'	=> array('jquery.dataTables.min', 'admin/list')
		);
		
		$this->load->model('model_user');
		$db_query = $this->model_user->get_data();
		
		$data['result'] = $db_query;

		$this->show('admin/' . $this->url . '/list_' . $this->url, $data);
	}
	
	public function add()
	{
		$data = array(
			'title'	=> 'Add ' . $this->title,
			'css'	=> array(),
			'js'	=> array()
		);

		$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
	}
}


/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */