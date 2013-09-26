<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('form_value'))
{
	function form_value($field_name, $row)
	{
		return (set_value($field_name)) ? set_value($field_name) : $row[$field_name];
	}
}

if ( ! function_exists('check_admin_login'))
{
	function check_admin_login($result = '')
	{
		$ci =& get_instance();
		
		if ($result == 'redirect')
		{
			if ($ci->session->userdata('admin_logged_in') == FALSE)
			{
				$ci->session->set_flashdata('login_form_message', '<strong>Please login first</strong>');
				redirect(base_url('admin'));
			}
		}
		else
		{
			if ($ci->session->userdata('admin_logged_in') == FALSE)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
}

if ( ! function_exists('table_end'))
{
	function table_end($row)
	{
		if ($row['flag'] == 1)
		{
			$class = 'active';
		}
		elseif ($row['flag'] == 2)
		{
			$class = 'inactive';
		}
		
		echo '<td class="status"><span class="flag ' . $class . '"></span><img src="' . base_url('images/ajax-loader.gif') . '" /></td>';
        echo '<td class="memo">' . $row['memo'] . '</td>';
		echo '<td class="del"><input type="checkbox" /></td>';
	}
}

if ( ! function_exists('get_unique_id'))
{
	function get_unique_id($db_table)
	{
		$ci =& get_instance();
		$query = $ci->db->select_max($db_table . '_id')->where('flag !=', 3)->get($db_table);
		
		$row = $query->row_array();
		
		return ($row) ? $row[$db_table . '_id'] + 1 : 1;
	}
}

if ( ! function_exists('log_action'))
{
	function log_action($action = '', $db = '', $value = '', $description = '')
	{
		$ci =& get_instance();
		
		$data = array(
			'log_admin_id'		=> $ci->session->userdata('admin_id'),
			'log_action'		=> $action,
			'log_db'			=> $db,
			'log_value'			=> $value,
			'log_description'	=> $description,
			'log_ip'			=> $ci->input->ip_address(),
			'log_time'			=> date('Y-m-d H:i:s')
		);
		
		$ci->db->insert('log', $data);
	}
}


/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */