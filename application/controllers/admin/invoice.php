<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends MY_Controller {

	var $title = 'Invoice';
	var $url = 'invoice';
	var $db_table = 'invoice';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_invoice');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_invoice->list_data();
		
		$data['result'] = $db_query;

		$this->show('admin/' . $this->url . '/list_' . $this->url, $data);
	}
	
	public function add()
	{
		$data = array(
			'title'	=> 'Add ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap'),
			'js'	=> array('alertify', 'admin/form')
		);
		
		$data['bank_list'] = $this->model_project->get_bank();
		$data['product_list'] = $this->model_project->get_product();
		$data['admin_list'] = $this->model_project->get_admin();
		
		foreach ($this->model_project->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_project->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		$this->form_validation->set_rules('project_name', 'project name', 'trim|required');
		$this->form_validation->set_rules('project_product_id', 'product', 'trim|required');
		$this->form_validation->set_rules('project_sales_id', 'sales', 'trim');
		$this->form_validation->set_rules('project_price', 'price', 'trim|required');
		$this->form_validation->set_rules('project_markup', 'markup', 'trim');
		$this->form_validation->set_rules('project_note', 'note', 'trim');
		$this->form_validation->set_rules('project_bank_id', 'bank', 'required');
		$this->form_validation->set_rules('project_currency', 'currency', 'required');
		$this->form_validation->set_rules('project_customer_type', 'customer type', 'required');
		$this->form_validation->set_rules('project_top_type', 'top type', 'required');
		
		if ($this->input->post('project_customer_type') == 1)
		{
			$this->form_validation->set_rules('project_client_name', 'client name', 'trim|required');
		}
		if ($this->input->post('project_customer_type') == 2)
		{
			$this->form_validation->set_rules('project_company_name', 'company name ', 'trim|required');
		}

		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_project->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'admin/form', 'jquery.dataTables.min', 'admin/list')
		);
		
		$data['row'] = $this->model_invoice->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));

		$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
	}
}


/* End of file invoice.php */
/* Location: ./application/controllers/admin/invoice.php */