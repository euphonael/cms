<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MY_Controller {

	var $title = 'Company';
	var $url = 'company';
	var $db_table = 'company';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_company');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_company->list_data();
		
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
		
		foreach ($this->model_company->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		$this->form_validation->set_rules('company_name', 'company name', 'trim|required');
		$this->form_validation->set_rules('company_client_name', 'client name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'company address', 'trim');
		$this->form_validation->set_rules('company_country', 'company country', 'trim');
		$this->form_validation->set_rules('company_city', 'company city', 'trim');
		$this->form_validation->set_rules('company_postal_code', 'postal code', 'numeric');
		$this->form_validation->set_rules('company_phone', 'phone', 'trim');
		$this->form_validation->set_rules('company_mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('company_fax', 'fax', 'trim');
		$this->form_validation->set_rules('company_email', 'email', 'valid_email|trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_company->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array(),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_company->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		foreach ($this->model_company->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		$this->form_validation->set_rules('company_name', 'company name', 'trim|required');
		$this->form_validation->set_rules('company_client_name', 'client name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'company address', 'trim');
		$this->form_validation->set_rules('company_country', 'company country', 'trim');
		$this->form_validation->set_rules('company_city', 'company city', 'trim');
		$this->form_validation->set_rules('company_postal_code', 'postal code', 'numeric');
		$this->form_validation->set_rules('company_phone', 'phone', 'trim');
		$this->form_validation->set_rules('company_mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('company_fax', 'fax', 'trim');
		$this->form_validation->set_rules('company_email', 'email', 'valid_email|trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_company->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file company.php */
/* Location: ./application/controllers/admin/company.php */