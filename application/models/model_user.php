<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

	public function list_data()
	{
		$query = $this->db->select('unique_id, admin_username, admin_name, admin_join_date, admin_dob, admin_phone, admin_work_email, admin_job_position, admin_privilege, flag, memo')->where('flag !=', 3)->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->get_where($this->db_table, array('unique_id' => $unique_id));
		return $query->row_array();
	}
	
	public function insert()
	{
		$data = array(
			'admin_username'		=> $this->input->post('admin_username'),
			'admin_password'		=> $this->input->post('admin_password'),
			'admin_name'			=> $this->input->post('admin_name'),
			'admin_dob'				=> $this->input->post('admin_dob'),
			'admin_pob'				=> $this->input->post('admin_pob'),
			'admin_phone'			=> $this->input->post('admin_phone'),
			'admin_personal_email'	=> $this->input->post('admin_personal_email'),
			'admin_work_email'		=> $this->input->post('admin_work_email'),
			'admin_job_position'	=> $this->input->post('admin_job_position'),
			'admin_join_date'		=> $this->input->post('admin_join_date'),
			'admin_resign_date'		=> $this->input->post('admin_resign_date'),
			'admin_privilege'		=> 1, // Temporary default: 1
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		$last_insert_id = $this->db->insert_id();
		
		if (multi_language('user') == FALSE)
		{
			$this->db->where('admin_id', $last_insert_id);
			$this->db->update($this->db_table, array('unique_id' => $last_insert_id));
		}
	}
	
	public function update($unique_id)
	{
		$data = array(
			'admin_username'		=> $this->input->post('admin_username'),
			'admin_name'			=> $this->input->post('admin_name'),
			'admin_dob'				=> $this->input->post('admin_dob'),
			'admin_pob'				=> $this->input->post('admin_pob'),
			'admin_phone'			=> $this->input->post('admin_phone'),
			'admin_personal_email'	=> $this->input->post('admin_personal_email'),
			'admin_work_email'		=> $this->input->post('admin_work_email'),
			'admin_job_position'	=> $this->input->post('admin_job_position'),
			'admin_join_date'		=> $this->input->post('admin_join_date'),
			'admin_resign_date'		=> $this->input->post('admin_resign_date'),
			'admin_privilege'		=> 1, // Temporary default: 1
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		/* Password */
		if ($this->input->post('admin_password'))
		{
			$data['admin_password'] = $this->input->post('admin_password');
		}
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
	}

}

/* End of file model_user.php */
/* Location: ./application/models/model_user.php */