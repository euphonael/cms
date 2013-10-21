<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_product extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('unique_id, product_name, product_code, flag, memo')->order_by('product_code', 'asc')->where('flag !=', 3)->get($this->db_table);
		
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
			'product_name'			=> $this->input->post('product_name'),
			'product_code'			=> $this->input->post('product_code'),
			'product_description'	=> $this->input->post('product_description'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'product_name'			=> $this->input->post('product_name'),
			'product_code'			=> $this->input->post('product_code'),
			'product_description'	=> $this->input->post('product_description'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_product.php */
/* Location: ./application/models/model_product.php */