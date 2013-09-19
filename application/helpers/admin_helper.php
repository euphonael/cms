<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	}
}


/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */