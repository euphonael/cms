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
	
	public function delete_row($project_id = '')
	{
		$data = array(
			'flag'	=> 3
		);
		
		$this->db->where('unique_id', $this->input->post('unique_id'));
		$this->db->update($this->input->post('db_table'), $data);
		
		if ($this->input->post('db_table') == 'invoice')
		{
			$row = $this->db->select('project_invoice_count')->where('unique_id', $project_id)->get('project')->row_array();

			// Update project invoice count
			$this->db->where('unique_id', $project_id);
			$this->db->update('project', array('project_invoice_count' => $row['project_invoice_count'] - 1));
		}
	}
}


/* End of file model_ajax.php */
/* Location: ./application/models/model_ajax.php */