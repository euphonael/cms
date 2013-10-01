<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

	public function list_data()
	{
		$query = $this->db->select('unique_id, admin_username, admin_name, admin_join_date, admin_dob, admin_phone, admin_work_email, admin_job_position, admin_privilege, flag, memo')->order_by('unique_id', 'ASC')->where('flag !=', 3)->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->get_where($this->db_table, array('unique_id' => $unique_id));
		return $query->row_array();
	}
	
	public function get_module()
	{
		$query = $this->db->select('unique_id, module_name')->where(array('flag !=' => 3, 'module_url !=' => '#'))->get('module');
		return $query->result_array();
	}
	
	public function get_division()
	{
		$query = $this->db->select('unique_id, division_name')->where('flag !=', 3)->order_by('division_name', 'ASC')->get('division');
		return $query->result_array();
	}
	
	public function insert()
	{
		$this->load->helper('upload_helper');
		
		$admin_ktp = file_upload('admin_ktp', 'gif|jpeg|png|jpg', 'ktp', $this->db_table);
		$admin_npwp = file_upload('admin_npwp', 'gif|jpeg|png|jpg', 'npwp', $this->db_table);
		
		$file = array();
		
		if ($admin_ktp) $file['admin_ktp'] = $admin_ktp['file_name'];
		if ($admin_npwp) $file['admin_npwp'] = $admin_npwp['file_name'];
		
		$data = array(
			'unique_id'				=> get_unique_id($this->db_table),
			'admin_username'		=> $this->input->post('admin_username'),
			'admin_password'		=> $this->input->post('admin_password'),
			'admin_name'			=> $this->input->post('admin_name'),
			'admin_dob'				=> $this->input->post('admin_dob'),
			'admin_pob'				=> $this->input->post('admin_pob'),
			'admin_phone'			=> $this->input->post('admin_phone'),
			'admin_personal_email'	=> $this->input->post('admin_personal_email'),
			'admin_work_email'		=> $this->input->post('admin_work_email'),
			'admin_division'		=> $this->input->post('admin_division'),
			'admin_job_position'	=> $this->input->post('admin_job_position'),
			'admin_join_date'		=> $this->input->post('admin_join_date'),
			'admin_resign_date'		=> $this->input->post('admin_resign_date'),
			'admin_privilege'		=> $this->input->post('admin_privilege'),
			'admin_module_list'		=> '',
			'admin_module_access'	=> '',
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		if ($this->input->post('admin_privilege') == 3)
		{			
			foreach ($this->get_module() as $item)
			{
				$module_list[$item['unique_id']] = $this->input->post('module-total-' . $item['unique_id']);
			}
			
			$data['admin_module_list'] = implode(',', array_keys($module_list));
			$data['admin_module_access'] = implode(',', array_values($module_list));
		}
		
		$data = array_merge($data, $file);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{
		$this->load->helper('upload_helper');
		
		$file = array();
		
		if ($this->input->post('admin_ktp_delete') == 1)
		{
			remove_file($this->db_table, 'admin_ktp', $unique_id, 'ktp');
			$file['admin_ktp'] = '';
		}
		
		if ($this->input->post('admin_npwp_delete') == 1)
		{
			remove_file($this->db_table, 'admin_npwp', $unique_id, 'npwp');
			$file['admin_npwp'] = '';
		}
		
		$admin_ktp = file_upload('admin_ktp', 'gif|jpeg|png|jpg|xls|xlsx', 'ktp', $this->db_table, $unique_id);
		$admin_npwp = file_upload('admin_npwp', 'gif|jpeg|png|jpg', 'npwp', $this->db_table, $unique_id);
		
		if ($admin_ktp) $file['admin_ktp'] = $admin_ktp['file_name'];
		if ($admin_npwp) $file['admin_npwp'] = $admin_npwp['file_name'];
		
		$data = array(
			'admin_username'		=> $this->input->post('admin_username'),
			'admin_name'			=> $this->input->post('admin_name'),
			'admin_dob'				=> $this->input->post('admin_dob'),
			'admin_pob'				=> $this->input->post('admin_pob'),
			'admin_phone'			=> $this->input->post('admin_phone'),
			'admin_personal_email'	=> $this->input->post('admin_personal_email'),
			'admin_work_email'		=> $this->input->post('admin_work_email'),
			'admin_division'		=> $this->input->post('admin_division'),
			'admin_job_position'	=> $this->input->post('admin_job_position'),
			'admin_join_date'		=> $this->input->post('admin_join_date'),
			'admin_resign_date'		=> $this->input->post('admin_resign_date'),
			'admin_privilege'		=> $this->input->post('admin_privilege'),
			'admin_module_list'		=> '',
			'admin_module_access'	=> '',
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		if ($this->input->post('admin_password')) $data['admin_password'] = $this->input->post('admin_password');
		
		if ($this->input->post('admin_privilege') == 3)
		{			
			foreach ($this->get_module() as $item)
			{
				$module_list[$item['unique_id']] = $this->input->post('module-total-' . $item['unique_id']);
			}
			
			$data['admin_module_list'] = implode(',', array_keys($module_list));
			$data['admin_module_access'] = implode(',', array_values($module_list));
		}
		
		$data = array_merge($data, $file);
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}

}


/* End of file model_user.php */
/* Location: ./application/models/model_user.php */