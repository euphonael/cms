<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hosting extends MY_Controller {

	var $title = 'Hosting';
	var $url = 'hosting';
	var $db_table = 'hosting';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_hosting');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_hosting->list_data();
		
		$data['result'] = $db_query;

		$this->show('admin/' . $this->url . '/list_' . $this->url, $data);
	}
	
	public function add()
	{
		$data = array(
			'title'	=> 'Add ' . $this->title,
			'css'	=> array(),
			'js'	=> array('admin/form')
		);
		
		$this->form_validation->set_rules('hosting_name', 'hosting name', 'trim|required');
		$this->form_validation->set_rules('hosting_root_domain', 'hosting root domain', 'trim|required');
		$this->form_validation->set_rules('hosting_expiry', 'expiry date', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_url', 'cpanel url', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_username', 'cpanel username', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_password', 'cpanel password', 'trim|required');
		$this->form_validation->set_rules('hosting_disk_space', 'disk space', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_subdomain', 'subdomain', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_addon_domain', 'addon domain', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_mysql_db', 'mysql db', 'trim|numeric|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_hosting->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array(),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_hosting->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$this->form_validation->set_rules('hosting_name', 'hosting name', 'trim|required');
		$this->form_validation->set_rules('hosting_root_domain', 'hosting root domain', 'trim|required');
		$this->form_validation->set_rules('hosting_expiry', 'expiry date', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_url', 'cpanel url', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_username', 'cpanel username', 'trim|required');
		$this->form_validation->set_rules('hosting_cpanel_password', 'cpanel password', 'trim|required');
		$this->form_validation->set_rules('hosting_disk_space', 'disk space', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_subdomain', 'subdomain', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_addon_domain', 'addon domain', 'trim|numeric|required');
		$this->form_validation->set_rules('hosting_mysql_db', 'mysql db', 'trim|numeric|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_hosting->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file hosting.php */
/* Location: ./application/controllers/admin/hosting.php */