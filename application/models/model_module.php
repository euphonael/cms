<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_module extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.module_name, m.module_notes, m.flag, m.memo, f.module_name AS module_parent_name')->join('module f', 'f.unique_id = m.module_parent', 'left')->where('m.flag !=', 3)->order_by('m.unique_id', 'ASC')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get_parent()
	{	
		$query = $this->db->select('unique_id, module_name')->where(array('flag !=' => 3, 'module_parent' => 0))->order_by('unique_id', 'ASC')->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->get_where($this->db_table, array('unique_id' => $unique_id));
		return $query->row_array();
	}
	
	public function insert()
	{		
		$data = array(
			'unique_id'				=> get_unique_id($this->db_table),
			'module_name'			=> $this->input->post('module_name'),
			'module_url'			=> $this->input->post('module_url'),
			'module_parent'			=> $this->input->post('module_parent'),
			'module_multi_language'	=> $this->input->post('module_multi_language'),
			'module_notes'			=> $this->input->post('module_notes'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'module_name'			=> $this->input->post('module_name'),
			'module_url'			=> $this->input->post('module_url'),
			'module_parent'			=> $this->input->post('module_parent'),
			'module_multi_language'	=> $this->input->post('module_multi_language'),
			'module_notes'			=> $this->input->post('module_notes'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_module.php */
/* Location: ./application/models/model_module.php */