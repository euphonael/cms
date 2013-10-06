<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Domain extends MY_Controller {

	var $title = 'Domain';
	var $url = 'domain';
	var $db_table = 'domain';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_domain');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_domain->list_data();
		
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
		
		$this->form_validation->set_rules('domain_name', 'domain name', 'trim|required');
		$this->form_validation->set_rules('domain_location', 'domain location', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_domain->insert();
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
		
		$data['row'] = $this->model_domain->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$this->form_validation->set_rules('domain_name', 'domain name', 'trim|required');
		$this->form_validation->set_rules('domain_location', 'domain location', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_domain->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file domain.php */
/* Location: ./application/controllers/admin/domain.php */