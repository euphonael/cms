<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $error_message = '';
		
	public function index()
	{
		if ($this->session->userdata('admin_logged_in') === TRUE)
		{
			redirect(base_url('admin/dashboard'));
		}
		
		$data = array(
			'title'	=> 'Admin Login',
			'css'	=> array(),
			'js'	=> array()
		);
		
		$this->form_validation->set_rules('admin_username', 'username', 'trim|required');
		$this->form_validation->set_rules('admin_password', 'password', 'required|md5');
		
		if ($this->form_validation->run() == FALSE)
		{					
			$this->load->view('admin/template/header', $data);
			$this->load->view('admin/login_view');
			$this->load->view('admin/template/footer');
		}
		else
		{
			$this->load->model('model_security');
			
			$login_process = $this->model_security->admin_login();
			
			if ($login_process === TRUE)
			{
				redirect(base_url('admin/dashboard'));
			}
			elseif ($login_process === FALSE)
			{
				$this->session->set_flashdata('login_form_message', '<strong>Inactive User</strong>');
				redirect(base_url('admin'));
			}
			elseif ($login_process === NULL)
			{
				$this->session->set_flashdata('login_form_message', '<strong>Invalid username / password</strong>');
				redirect(base_url('admin'));
			}
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */