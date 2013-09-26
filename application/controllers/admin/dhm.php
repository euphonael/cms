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
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_dhm->list_data();
		
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
		
		$data['company_list'] = $this->model_dhm->get_company();
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		$data['bank_list'] = $this->model_dhm->get_bank();
		
		$this->form_validation->set_rules('dhm_name', 'dhm name', 'trim|required');
		$this->form_validation->set_rules('dhm_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('dhm_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_price', 'price', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_extend', 'extend period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_company_id', 'company name', 'trim|required');
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
	
	function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('jquery.fancybox'),
			'js'	=> array('admin/form')
		);
		
		$data['row'] = $this->model_dhm->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['company_list'] = $this->model_dhm->get_company();
		$data['domain_list'] = $this->model_dhm->get_domain();
		$data['hosting_list'] = $this->model_dhm->get_hosting();
		$data['bank_list'] = $this->model_dhm->get_bank();
		
		$this->form_validation->set_rules('dhm_name', 'dhm name', 'trim|required');
		$this->form_validation->set_rules('dhm_start', 'start date', 'trim|required');
		$this->form_validation->set_rules('dhm_period', 'period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_price', 'price', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_extend', 'extend period', 'numeric|trim|required');
		$this->form_validation->set_rules('dhm_company_id', 'company name', 'trim|required');
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
}


/* End of file hosting.php */
/* Location: ./application/controllers/admin/hosting.php */