<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends MY_Controller {

	var $title = 'Maintenance';
	var $url = 'maintenance';
	var $db_table = 'maintenance';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_maintenance');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('jquery.fancybox', 'alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('jquery.fancybox.pack', 'alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_maintenance->list_data();
		
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
		
		$data['company_list'] = $this->model_maintenance->get_company();
		$data['bank_list'] = $this->model_maintenance->get_bank();
		
		foreach ($this->model_maintenance->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_maintenance->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		$this->form_validation->set_rules('maintenance_name', 'maintenance name', 'trim|required');
		$this->form_validation->set_rules('maintenance_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('maintenance_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_price', 'price', 'trim|required');
		$this->form_validation->set_rules('maintenance_markup', 'markup', 'trim');
		$this->form_validation->set_rules('maintenance_customer_type', 'customer type', 'required');
		
		if ($this->input->post('maintenance_customer_type') == 1)
		{
			$this->form_validation->set_rules('maintenance_client_name', 'client_name', 'trim|required');
		}
		if ($this->input->post('maintenance_customer_type') == 2)
		{
			$this->form_validation->set_rules('maintenance_company_name', 'company ', 'trim|required');
		}
		
		$this->form_validation->set_rules('maintenance_extend', 'extend period', 'numeric|trim');
		$this->form_validation->set_rules('maintenance_bank_id', 'bank name', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_maintenance->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap'),
			'js'	=> array('alertify', 'admin/form')
		);
		
		$data['row'] = $this->model_maintenance->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['company_list'] = $this->model_maintenance->get_company();
		$data['bank_list'] = $this->model_maintenance->get_bank();
		
		foreach ($this->model_maintenance->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_maintenance->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		$this->form_validation->set_rules('maintenance_name', 'maintenance name', 'trim|required');
		$this->form_validation->set_rules('maintenance_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('maintenance_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_price', 'price', 'trim|required');
		$this->form_validation->set_rules('maintenance_markup', 'markup', 'trim');
		$this->form_validation->set_rules('maintenance_customer_type', 'customer type', 'required');
		
		if ($this->input->post('maintenance_customer_type') == 1)
		{
			$this->form_validation->set_rules('maintenance_client_name', 'client_name', 'trim|required');
		}
		if ($this->input->post('maintenance_customer_type') == 2)
		{
			$this->form_validation->set_rules('maintenance_company_name', 'company ', 'trim|required');
		}
		
		$this->form_validation->set_rules('maintenance_bank_id', 'bank name', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_maintenance->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function extend($unique_id)
	{
		$data = array(
			'title'	=> 'Extend ' . $this->title,
			'css'	=> array(),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_maintenance->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));

		$data['bank_list'] = $this->model_maintenance->get_bank();
		$data['product_list'] = $this->model_maintenance->get_product();
		
		$this->form_validation->set_rules('invoice_project_name', 'project name', 'trim|required');
		$this->form_validation->set_rules('maintenance_period', 'period', 'required');
		$this->form_validation->set_rules('maintenance_product_id', 'product', 'required');
		$this->form_validation->set_rules('maintenance_bank_id', 'bank', 'required');
		$this->form_validation->set_rules('bank_currency', 'currency', 'required');
		$this->form_validation->set_rules('maintenance_price', 'price', 'required');
		$this->form_validation->set_rules('maintenance_markup', 'mark-up', 'required');
		$this->form_validation->set_rules('invoice_note', 'note', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/template/header', $data);
			$this->load->view('admin/' . $this->url . '/' . $this->url . '_extend');
			$this->load->view('admin/template/footer');
		}
		else
		{
			$this->model_maintenance->extend($unique_id);
		}
	}
}


/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */