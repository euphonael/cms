<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_domain extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('unique_id, domain_name, domain_location, flag, memo')->where('flag !=', 3)->get($this->db_table);
		
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
			'domain_name'			=> $this->input->post('domain_name'),
			'domain_location'		=> $this->input->post('domain_location'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'domain_name'			=> $this->input->post('domain_name'),
			'domain_location'		=> $this->input->post('domain_location'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_domain.php */
/* Location: ./application/models/model_domain.php */