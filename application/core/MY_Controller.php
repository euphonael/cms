<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	protected $data = array();
	
	public function show($view, $data)
	{
		$this->load->model('model_security');
		
		$data['menu'] = $this->model_security->get_menu();
		
		$this->load->view('admin/template/header', $data);
		$this->load->view('admin/template/menu');
		$this->load->view($view);
		$this->load->view('admin/template/footer');
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */