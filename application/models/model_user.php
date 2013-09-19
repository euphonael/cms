<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

	public function get_data()
	{
		$query = $this->db->select('unique_id, admin_username, admin_name, admin_join_date, admin_dob, admin_phone, admin_work_email, admin_job_position, admin_privilege, flag, memo')->where('flag !=', 3)->get('admin');
		
		return $query->result_array();
	}

}

/* End of file model_user.php */
/* Location: ./application/models/model_user.php */