<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	var $title = 'User';
	var $url = 'user';
	var $db_table = 'admin';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_user');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$where = "flag != 3";
		
		if ($this->input->post('admin_status') == 1) $where .= " AND admin_resign_date = '0000-00-00'";
		elseif ($this->input->post('admin_status') == 2) $where .= " AND admin_resign_date != '0000-00-00'";
		
		if ($this->input->post('admin_division')) $where .= " AND admin_division = '" . $this->input->post('admin_division') . "'";
		
		if ($this->input->post('duration_type'))
		{
			$sign = $this->input->post('duration_type');
			if ($this->input->post('duration'))
			{
				/*
				AND PERIOD_DIFF(date_format(NOW(), '%Y%m'), date_format(admin_join_date, '%Y%m')) = 31 OR PERIOD_DIFF(date_format(admin_resign_date, '%Y%m'), date_format(admin_join_date, '%Y%m')) = 31
				*/
				$where .= " 
				AND PERIOD_DIFF(date_format(NOW(), '%Y%m'), date_format(admin_join_date, '%Y%m')) " . $sign . " '" . $this->input->post('duration') . "'
				OR (PERIOD_DIFF(date_format(admin_resign_date, '%Y%m'), date_format(admin_join_date, '%Y%m')) " . $sign . " '" . $this->input->post('duration') . "'
				AND PERIOD_DIFF(date_format(admin_resign_date, '%Y%m'), date_format(admin_join_date, '%Y%m')) > 0)
				";
			}
		}
		
		$db_query = $this->model_user->list_data($where);
		$data['division_list'] = $this->model_user->get_division();
		
#		echo $db_query;
#		exit;
		$data['result'] = $this->db->query($db_query)->result_array();

		$this->show('admin/' . $this->url . '/list_' . $this->url, $data);
	}
	
	public function add()
	{
		$data = array(
			'title'	=> 'Add ' . $this->title,
			'css'	=> array(),
			'js'	=> array('admin/form', 'admin/privilege')
		);
		
		$data['module_list'] = $this->model_user->get_module();
		$data['division_list'] = $this->model_user->get_division();
		
		$this->form_validation->set_rules('admin_username', 'Username', 'trim|required|is_unique[admin.admin_username]');
		$this->form_validation->set_rules('admin_password', 'Password', 'matches[admin_repassword]|required|md5');
		$this->form_validation->set_rules('admin_repassword', 'admin_repassword', 'required');
		$this->form_validation->set_rules('admin_name', 'name', 'trim|required');
		$this->form_validation->set_rules('admin_phone', 'phone', 'trim');
		$this->form_validation->set_rules('admin_personal_email', 'E-mail', 'trim|valid_email|is_unique[admin.admin_personal_email]');
		$this->form_validation->set_rules('admin_work_email', 'E-mail', 'trim|valid_email|required|is_unique[admin.admin_work_email]');
		$this->form_validation->set_rules('admin_division', 'division', 'required');
		$this->form_validation->set_rules('admin_job_position', 'job position', 'trim|required');
		$this->form_validation->set_rules('admin_privilege', 'privilege', 'required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_user->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('jquery.fancybox'),
			'js'	=> array('admin/form', 'jquery.fancybox.pack', 'admin/file_handling', 'admin/privilege')
		);
		
		$data['row'] = $this->model_user->get($unique_id);
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['module_list'] = $this->model_user->get_module();
		$data['division_list'] = $this->model_user->get_division();
		
		$this->form_validation->set_rules('admin_username', 'Username', 'trim|required|is_unique[admin.admin_username.unique_id.' . $unique_id . ']');
		$this->form_validation->set_rules('admin_password', 'Password', 'matches[admin_repassword]|md5');
		$this->form_validation->set_rules('admin_name', 'name', 'trim|required');
		$this->form_validation->set_rules('admin_phone', 'phone', 'trim');
		$this->form_validation->set_rules('admin_personal_email', 'E-mail', 'trim|valid_email|is_unique[admin.admin_personal_email.unique_id.' . $unique_id . ']]');
		$this->form_validation->set_rules('admin_work_email', 'E-mail', 'trim|valid_email|required|is_unique[admin.admin_work_email.unique_id.' . $unique_id . ']]');
		$this->form_validation->set_rules('admin_division', 'division', 'required');
		$this->form_validation->set_rules('admin_job_position', 'job position', 'trim|required');
		$this->form_validation->set_rules('admin_privilege', 'privilege', 'required');
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_user->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
}


/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */