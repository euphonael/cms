<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
		
	public function index()
	{
		log_action('LOGOUT', 'admin', $this->session->userdata('admin_id'), 'Logout Success');
		
		$admin_session = array(
			'admin_id'			=> '',
			'admin_logged_in'	=> FALSE,
			'admin_name'		=> ''
		);
		
		$this->session->set_userdata($admin_session);
		
		$this->session->set_flashdata('login_form_message', '<strong>You have been logged out</strong>');
		redirect(base_url('admin'));
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/admin/logout.php */