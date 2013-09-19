<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ajax extends CI_Model {

	public function toggle_status()
	{
		if ($this->input->post('current_status') == 'active')
		{
			$new_status = 2;
		}
		elseif ($this->input->post('current_status') == 'inactive')
		{
			$new_status = 1;
		}
		
		$data = array(
			'flag'	=> $new_status,
			'memo'	=> $this->input->post('memo')
		);
		
		$this->db->where('unique_id', $this->input->post('unique_id'));
		$this->db->update($this->input->post('db_table'), $data);
	}
}

/* End of file model_ajax.php */
/* Location: ./application/models/model_ajax.php */