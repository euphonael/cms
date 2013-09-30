<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_maintenance extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.maintenance_name, m.maintenance_price, m.maintenance_start, com.company_name, ban.bank_name, m.flag, m.memo')->select('DATE_ADD(m.maintenance_start, INTERVAL m.maintenance_period MONTH) as maintenance_end', false)->where('m.flag !=', 3)->join('company com', 'com.unique_id = m.maintenance_company_id', 'left')->join('bank ban', 'ban.unique_id = m.maintenance_bank_id', 'left')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->get_where($this->db_table, array('unique_id' => $unique_id));
		return $query->row_array();
	}
	
	public function get_company()
	{
		$query = $this->db->select('unique_id, company_name')->where('flag !=', 3)->get('company');
		return $query->result_array();
	}
	
	public function get_bank()
	{
		$query = $this->db->select('unique_id, bank_name')->where('flag !=', 3)->get('bank');
		return $query->result_array();
	}
	
	public function insert()
	{
		$data = array(
			'unique_id'					=> get_unique_id($this->db_table),
			'maintenance_name'			=> $this->input->post('maintenance_name'),
			'maintenance_start'			=> $this->input->post('maintenance_start'),
			'maintenance_period'		=> $this->input->post('maintenance_period'),
			'maintenance_price'			=> $this->input->post('maintenance_price'),
			'maintenance_extend'		=> $this->input->post('maintenance_extend'),
			'maintenance_company_id'	=> $this->input->post('maintenance_company_id'),
			'maintenance_bank_id'		=> $this->input->post('maintenance_bank_id'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'maintenance_name'			=> $this->input->post('maintenance_name'),
			'maintenance_start'			=> $this->input->post('maintenance_start'),
			'maintenance_period'		=> $this->input->post('maintenance_period'),
			'maintenance_price'			=> $this->input->post('maintenance_price'),
			'maintenance_extend'		=> $this->input->post('maintenance_extend'),
			'maintenance_company_id'	=> $this->input->post('maintenance_company_id'),
			'maintenance_bank_id'		=> $this->input->post('maintenance_bank_id'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_maintenance.php */
/* Location: ./application/models/model_maintenance.php */