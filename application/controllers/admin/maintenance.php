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
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_maintenance->list_data();
		
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
		
		$data['company_list'] = $this->model_maintenance->get_company();
		$data['bank_list'] = $this->model_maintenance->get_bank();
		
		$this->form_validation->set_rules('maintenance_name', 'maintenance name', 'trim|required');
		$this->form_validation->set_rules('maintenance_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('maintenance_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_price', 'price', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_extend', 'extend period', 'numeric|trim');
		$this->form_validation->set_rules('maintenance_company_id', 'company name', 'trim|required');
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
	
	function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('jquery.fancybox'),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_maintenance->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['company_list'] = $this->model_maintenance->get_company();
		$data['bank_list'] = $this->model_maintenance->get_bank();
		
		$this->form_validation->set_rules('maintenance_name', 'maintenance name', 'trim|required');
		$this->form_validation->set_rules('maintenance_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('maintenance_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_price', 'price', 'numeric|trim|required');
		$this->form_validation->set_rules('maintenance_extend', 'extend period', 'numeric|trim');
		$this->form_validation->set_rules('maintenance_company_id', 'company name', 'trim|required');
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
}


/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */