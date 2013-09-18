<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_admin_login'))
{
	function check_admin_login()
	{
		$ci =& get_instance();
		if ($ci->session->userdata('admin_logged_in') == FALSE)
		{
			$ci->session->set_flashdata('login_form_message', '<strong>Please login first</strong>');
			redirect(base_url('admin'));
		}
	}
}


/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */