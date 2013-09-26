<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dhm extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.dhm_name, m.dhm_price, m.dhm_start, com.company_name, dom.domain_name, hos.hosting_name, ban.bank_name, m.flag, m.memo')->where('m.flag !=', 3)->join('company com', 'com.unique_id = m.dhm_company_id', 'left')->join('domain dom', 'dom.unique_id = m.dhm_domain_id', 'left')->join('hosting hos', 'hos.unique_id = m.dhm_hosting_id', 'left')->join('bank ban', 'ban.unique_id = m.dhm_bank_id', 'left')->get($this->db_table . ' m');
		
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
	
	public function get_domain()
	{
		$query = $this->db->select('unique_id, domain_name')->where('flag !=', 3)->get('domain');
		return $query->result_array();
	}
	
	public function get_hosting()
	{
		$query = $this->db->select('unique_id, hosting_name')->where('flag !=', 3)->get('hosting');
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
			'unique_id'			=> get_unique_id($this->db_table),
			'dhm_name'			=> $this->input->post('dhm_name'),
			'dhm_start'			=> $this->input->post('dhm_start'),
			'dhm_period'		=> $this->input->post('dhm_period'),
			'dhm_price'			=> $this->input->post('dhm_price'),
			'dhm_extend'		=> $this->input->post('dhm_extend'),
			'dhm_company_id'	=> $this->input->post('dhm_company_id'),
			'dhm_domain_id'		=> $this->input->post('dhm_domain_id'),
			'dhm_hosting_id'	=> $this->input->post('dhm_hosting_id'),
			'dhm_bank_id'		=> $this->input->post('dhm_bank_id'),
			'flag'				=> $this->input->post('flag'),
			'memo'				=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'dhm_name'			=> $this->input->post('dhm_name'),
			'dhm_start'			=> $this->input->post('dhm_start'),
			'dhm_period'		=> $this->input->post('dhm_period'),
			'dhm_price'			=> $this->input->post('dhm_price'),
			'dhm_extend'		=> $this->input->post('dhm_extend'),
			'dhm_company_id'	=> $this->input->post('dhm_company_id'),
			'dhm_domain_id'		=> $this->input->post('dhm_domain_id'),
			'dhm_hosting_id'	=> $this->input->post('dhm_hosting_id'),
			'dhm_bank_id'		=> $this->input->post('dhm_bank_id'),
			'flag'				=> $this->input->post('flag'),
			'memo'				=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_hosting.php */
/* Location: ./application/models/model_hosting.php */