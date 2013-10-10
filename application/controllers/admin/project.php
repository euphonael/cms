<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_Controller {

	var $title = 'Project';
	var $url = 'project';
	var $db_table = 'project';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_project');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_project->list_data();
		
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
	
	public function add_top($current_count, $type)
	{
		$new = $current_count + 1;
		
		$style = ($type == 2) ? 'style="display:none;"' : '';
		
		$html = '<div class="project-top">';
		$html .= '<p>';
		$html .= '<label class="label-input" for="project_top_' . $new . '">Payment ' . $new . '</label>';
		$html .= '<input type="text" class="has-suffix required number-format" name="project_top[]" id="project_top_' . $new . '" value="" />';
		$html .= '<span class="suffix" ' . $style . '>%</span>';
		$html .= '<span class="clear"></span>';
		$html .= '</p>';
		$html .= '</div>';
		
		echo $html;
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'admin/form', 'jquery.dataTables.min', 'admin/list')
		);
		
		$data['row'] = $this->model_project->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['bank_list'] = $this->model_project->get_bank();
		$data['product_list'] = $this->model_project->get_product();
		$data['admin_list'] = $this->model_project->get_admin();
		
		$data['invoice_list'] = $this->model_project->get_invoice($unique_id);
		
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
			echo validation_errors();
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_project->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function create_invoice()
	{
		$this->model_project->create_invoice();
	}
}


/* End of file project.php */
/* Location: ./application/controllers/admin/project.php */