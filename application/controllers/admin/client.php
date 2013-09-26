<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends MY_Controller {

	var $title = 'Client';
	var $url = 'client';
	var $db_table = 'client';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_client');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_client->list_data();
		
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
		
		$data['company_list'] = $this->model_client->get_company();
		
		$this->form_validation->set_rules('client_name', 'client name', 'trim|required');
		$this->form_validation->set_rules('client_company_id', 'company id', 'trim');
		$this->form_validation->set_rules('client_address', 'client address', 'trim');
		$this->form_validation->set_rules('client_country', 'client country', 'trim');
		$this->form_validation->set_rules('client_city', 'client city', 'trim');
		$this->form_validation->set_rules('client_postal_code', 'postal code', 'integer');
		$this->form_validation->set_rules('client_phone', 'phone', 'trim');
		$this->form_validation->set_rules('client_mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('client_fax', 'fax', 'trim');
		$this->form_validation->set_rules('client_email', 'email', 'valid_email|trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_client->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('jquery.fancybox'),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_client->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['company_list'] = $this->model_client->get_company();
		
		$this->form_validation->set_rules('client_name', 'client name', 'trim|required');
		$this->form_validation->set_rules('client_company_id', 'company id', 'trim');
		$this->form_validation->set_rules('client_address', 'client address', 'trim');
		$this->form_validation->set_rules('client_country', 'client country', 'trim');
		$this->form_validation->set_rules('client_city', 'client city', 'trim');
		$this->form_validation->set_rules('client_postal_code', 'postal code', 'integer');
		$this->form_validation->set_rules('client_phone', 'phone', 'trim');
		$this->form_validation->set_rules('client_mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('client_fax', 'fax', 'trim');
		$this->form_validation->set_rules('client_email', 'email', 'valid_email|trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_client->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file client.php */
/* Location: ./application/controllers/admin/client.php */