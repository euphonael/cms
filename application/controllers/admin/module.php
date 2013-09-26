<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends MY_Controller {

	var $title = 'Module';
	var $url = 'module';
	var $db_table = 'module';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_module');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_module->list_data();
		
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
		
		$data['module_list'] = $this->model_module->get_parent();
		
		$this->form_validation->set_rules('module_name', 'module name', 'trim|required');
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required');
		$this->form_validation->set_rules('module_parent', 'module parent', 'required');
		$this->form_validation->set_rules('module_multi_language', 'module multi language', 'numeric');
		$this->form_validation->set_rules('module_notes', 'module_notes', 'trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_module->insert();
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
		
		$data['module_list'] = $this->model_module->get_parent();
		$data['row'] = $this->model_module->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$this->form_validation->set_rules('module_name', 'module name', 'trim|required');
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required');
		$this->form_validation->set_rules('module_parent', 'module parent', 'required');
		$this->form_validation->set_rules('module_multi_language', 'module multi language', 'numeric');
		$this->form_validation->set_rules('module_notes', 'module_notes', 'trim');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_module->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file module.php */
/* Location: ./application/controllers/admin/module.php */