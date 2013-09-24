<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_security extends CI_Model {
	
	public function admin_login()
	{
		$condition = array(
			'admin_username'	=> $this->input->post('admin_username'),
			'admin_password'	=> $this->input->post('admin_password')
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
	
	public function get_menu()
	{
		$menu = array();
		
		$condition = array(
			'module_parent'	=> 0,
			'flag'			=> 1
		);
		
		$query = $this->db->select('unique_id, module_name, module_url')->where($condition)->get('module');
		
		foreach ($query->result_array() as $parent_menu)
		{					
			$submenu_condition = array(
				'module_parent'	=> $parent_menu['unique_id'],
				'flag'			=> 1
			);
			
			$submenu_query = $this->db->select('unique_id, module_name, module_parent, module_url')->where($submenu_condition)->get('module');
			
			if ($submenu_query->num_rows() > 0)
			{
				$parent_menu['submenu'] = array();
				$parent_menu['has_submenu'] = 1;
			}
			else
			{
				$parent_menu['has_submenu'] = 0;
			}
			
			foreach ($submenu_query->result_array() as $child_menu)
			{
				array_push($parent_menu['submenu'], $child_menu);
			}
			
			$menu[] = $parent_menu;
		}
		
		return $menu;
	}
}

/* End of file model_security.php */
/* Location: ./application/models/model_security.php */