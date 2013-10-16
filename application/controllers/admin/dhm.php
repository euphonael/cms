<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dhm extends MY_Controller {

	var $title = 'DHM';
	var $url = 'dhm';
	var $db_table = 'dhm';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_dhm');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('jquery.fancybox', 'alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('jquery.fancybox.pack', 'alertify', 'jquery.dataTables.min', 'admin/list')
		);
		
		if ($this->input->post('flag')) $where['m.flag'] = $this->input->post('flag');
		else $where['m.flag'] = 1;
		
		if ($this->input->post('domain')) $where['m.dhm_domain_id'] = $this->input->post('domain');
		if ($this->input->post('hosting')) $where['m.dhm_hosting_id'] = $this->input->post('hosting');

		$db_query = $this->model_dhm->list_data($where);
		
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		
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
		
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		$data['bank_list'] = $this->model_dhm->get_bank();
		
		foreach ($this->model_dhm->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_dhm->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		$this->form_validation->set_rules('dhm_name', 'dhm name', 'trim|required');
		$this->form_validation->set_rules('dhm_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('dhm_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_price', 'price', 'trim|required');
		$this->form_validation->set_rules('dhm_markup', 'markup', 'trim');
		$this->form_validation->set_rules('dhm_customer_type', 'customer type', 'required');
		
		if ($this->input->post('dhm_customer_type') == 1)
		{
			$this->form_validation->set_rules('dhm_client_name', 'client_name', 'trim|required');
		}
		if ($this->input->post('dhm_customer_type') == 2)
		{
			$this->form_validation->set_rules('dhm_company_name', 'company ', 'trim|required');
		}
		
		$this->form_validation->set_rules('dhm_domain_id', 'domain name', 'trim|required');
		$this->form_validation->set_rules('dhm_hosting_id', 'hosting name', 'trim|required');
		$this->form_validation->set_rules('dhm_bank_id', 'bank name', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_dhm->insert();
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
		
		$data['row'] = $this->model_dhm->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		$data['bank_list'] = $this->model_dhm->get_bank();
		
		foreach ($this->model_dhm->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_dhm->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		$this->form_validation->set_rules('dhm_name', 'dhm name', 'trim|required');
		$this->form_validation->set_rules('dhm_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('dhm_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_price', 'price', 'trim|required');
		$this->form_validation->set_rules('dhm_markup', 'markup', 'trim');
		$this->form_validation->set_rules('dhm_customer_type', 'customer type', 'required');
		
		if ($this->input->post('dhm_customer_type') == 1)
		{
			$this->form_validation->set_rules('dhm_client_name', 'client_name', 'trim|required');
		}
		if ($this->input->post('dhm_customer_type') == 2)
		{
			$this->form_validation->set_rules('dhm_company_name', 'company ', 'trim|required');
		}
		
		$this->form_validation->set_rules('dhm_domain_id', 'domain name', 'trim|required');
		$this->form_validation->set_rules('dhm_hosting_id', 'hosting name', 'trim|required');
		$this->form_validation->set_rules('dhm_bank_id', 'bank name', 'trim|required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_dhm->update($unique_id);
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
		
		$data['row'] = $this->model_dhm->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		$data['bank_list'] = $this->model_dhm->get_bank();
		
		$this->form_validation->set_rules('invoice_project_name', 'project name', 'trim|required');
		$this->form_validation->set_rules('dhm_period', 'period', 'required');
		$this->form_validation->set_rules('dhm_bank_id', 'bank', 'required');
		$this->form_validation->set_rules('bank_currency', 'currency', 'required');
		$this->form_validation->set_rules('dhm_price', 'price', 'required');
		$this->form_validation->set_rules('dhm_markup', 'mark-up', 'required');
		$this->form_validation->set_rules('invoice_note', 'note', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/template/header', $data);
			$this->load->view('admin/' . $this->url . '/' . $this->url . '_extend');
			$this->load->view('admin/template/footer');
		}
		else
		{
			$this->model_dhm->extend($unique_id);
		}
	}
}


/* End of file dhm.php */
/* Location: ./application/controllers/admin/dhm.php */