<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_bank extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('unique_id, bank_name, bank_branch, bank_account_holder, bank_account_number, bank_currency, bank_invoice_type, bank_swift_code, flag, memo')->where('flag !=', 3)->get($this->db_table);
		
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
			'bank_name'				=> $this->input->post('bank_name'),
			'bank_branch'			=> $this->input->post('bank_branch'),
			'bank_account_holder'	=> $this->input->post('bank_account_holder'),
			'bank_account_number'	=> $this->input->post('bank_account_number'),
			'bank_swift_code'		=> $this->input->post('bank_swift_code'),
			'bank_currency'			=> $this->input->post('bank_currency'),
			'bank_invoice_type'		=> $this->input->post('bank_invoice_type'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'bank_name'				=> $this->input->post('bank_name'),
			'bank_branch'			=> $this->input->post('bank_branch'),
			'bank_account_holder'	=> $this->input->post('bank_account_holder'),
			'bank_account_number'	=> $this->input->post('bank_account_number'),
			'bank_swift_code'		=> $this->input->post('bank_swift_code'),
			'bank_currency'			=> $this->input->post('bank_currency'),
			'bank_invoice_type'		=> $this->input->post('bank_invoice_type'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
	}
}


/* End of file model_bank.php */
/* Location: ./application/models/model_bank.php */