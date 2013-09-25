<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends MY_Controller {

	var $title = 'Bank';
	var $url = 'bank';
	var $db_table = 'bank';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_bank');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_bank->list_data();
		
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
		
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
		$this->form_validation->set_rules('bank_branch', 'branch', 'trim|required');
		$this->form_validation->set_rules('bank_account_holder', 'account holder', 'trim|required');
		$this->form_validation->set_rules('bank_account_number', 'account number', 'trim|required');
		$this->form_validation->set_rules('bank_swift_code', 'swift code', 'trim');
		$this->form_validation->set_rules('bank_currency', 'currency', 'required');
		$this->form_validation->set_rules('bank_invoice_type', 'invoice type', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_bank->insert();
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
		
		$data['row'] = $this->model_bank->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');
		$this->form_validation->set_rules('bank_branch', 'branch', 'trim|required');
		$this->form_validation->set_rules('bank_account_holder', 'account holder', 'trim|required');
		$this->form_validation->set_rules('bank_account_number', 'account number', 'trim|required');
		$this->form_validation->set_rules('bank_swift_code', 'swift code', 'trim');
		$this->form_validation->set_rules('bank_currency', 'currency', 'required');
		$this->form_validation->set_rules('bank_invoice_type', 'invoice type', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_bank->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file module.php */
/* Location: ./application/controllers/admin/module.php */