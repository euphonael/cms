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
			'unique_id'				=> get_unique_id($this->db_table),
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
	}
	
	public function update($unique_id)
	{
		$this->load->helper('upload_helper');
		
		$file = array();
		
		$admin_ktp = file_upload('admin_ktp', 'gif|jpeg|png|jpg', 'ktp');
		
		if ($admin_ktp)
		{
			remove_file($this->db_table, 'admin_ktp', $unique_id, 'ktp');
			$file['admin_ktp'] = $admin_ktp['file_name'];
		}
		
		$admin_npwp = file_upload('admin_npwp', 'gif|jpeg|png|jpg', 'npwp');
		
		if ($admin_npwp)
		{
			remove_file($this->db_table, 'admin_npwp', $unique_id, 'npwp');
			$file['admin_npwp'] = $admin_npwp['file_name'];
		}
		
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

		if ($this->input->post('admin_password')) $data['admin_password'] = $this->input->post('admin_password');
		
		$data = array_merge($data, $file);
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
	}

}


/* End of file model_user.php */
/* Location: ./application/models/model_user.php */