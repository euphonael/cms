<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_division extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.division_name, m.division_head, f.admin_name, m.flag, m.memo')->join('admin f', 'f.unique_id = m.division_head', 'left')->where('m.flag !=', 3)->order_by('m.unique_id', 'ASC')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->get_where($this->db_table, array('unique_id' => $unique_id));
		return $query->row_array();
	}
	
	public function get_admin()
	{
		$query = $this->db->select('unique_id, admin_name')->order_by('admin_name', 'ASC')->where('flag !=', 3)->get('admin');
		return $query->result_array();
	}
	
	public function insert()
	{
		$data = array(
			'unique_id'		=> get_unique_id($this->db_table),
			'division_name'	=> $this->input->post('division_name'),
			'division_head'	=> $this->input->post('division_head'),
			'flag'			=> $this->input->post('flag'),
			'memo'			=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'division_name'	=> $this->input->post('division_name'),
			'division_head'	=> $this->input->post('division_head'),
			'flag'			=> $this->input->post('flag'),
			'memo'			=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_division.php */
/* Location: ./application/models/model_division.php */