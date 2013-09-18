<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_security extends CI_Model {
	
	public function admin_login()
	{
		$condition = array(
			'admin_username'	=> $this->input->post('admin-username'),
			'admin_password'	=> $this->input->post('admin-password')
		);
		
		$query = $this->db->select('admin_name, unique_id, flag')->where($condition)->get('admin');
		
		if ($query->num_rows() == 1)
		{
			$row = $query->row_array();

			if ($row['flag'] == 1)
			{
				$admin_session = array(
					'admin_logged_in'	=> TRUE,
					'admin_name'		=> $row['admin_name']
				);
				
				$this->session->set_userdata($admin_session);
				
				return TRUE;
			}
			elseif ($row['flag'] == 2)
			{
				return FALSE;
			}
			elseif ($row['flag'] == 3)
			{
				return NULL;
			}
		}
		else
		{
			return NULL;
		}
	}
}

/* End of file model_security.php */
/* Location: ./application/models/model_security.php */