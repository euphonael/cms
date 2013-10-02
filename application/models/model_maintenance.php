<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_maintenance extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.maintenance_name, maintenance_period, client_name, m.maintenance_price, m.maintenance_start, com.company_name, ban.bank_name, m.flag, m.memo')->select('DATE_ADD(m.maintenance_start, INTERVAL m.maintenance_period MONTH) as maintenance_end', false)->where('m.flag !=', 3)->join('company com', 'com.unique_id = m.maintenance_company_id', 'left')->join('client', 'client.unique_id = maintenance_client_id', 'left')->join('bank ban', 'ban.unique_id = m.maintenance_bank_id', 'left')->order_by('maintenance_end', 'ASC')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('maintenance.unique_id, maintenance_name, maintenance_customer_type, maintenance_company_id, maintenance_client_id, maintenance_start, maintenance_period, client_name AS maintenance_client_name, company_name AS maintenance_company_name, maintenance_price, maintenance_markup, maintenance_extend, maintenance_bank_id, maintenance.flag, maintenance.memo')->join('company', 'company.unique_id = maintenance_company_id', 'left')->join('client', 'client.unique_id = maintenance_client_id', 'left')->where(array('maintenance.unique_id' => $unique_id))->get($this->db_table);
		return $query->row_array();
	}
	
	public function get_bank()
	{
		$query = $this->db->select('unique_id, bank_name, bank_account_holder, bank_account_number')->where('flag !=', 3)->get('bank');
		return $query->result_array();
	}
	
	public function get_company()
	{
		$query = $this->db->select('company_name')->where('flag !=', 3)->get('company');
		return $query->result_array();
	}
	
	public function get_client()
	{
		$query = $this->db->select('client_name')->where('flag !=', 3)->get('client');
		return $query->result_array();
	}
	
	public function insert()
	{
		$data = array(
			'unique_id'					=> get_unique_id($this->db_table),
			'maintenance_name'			=> $this->input->post('maintenance_name'),
			'maintenance_customer_type'	=> $this->input->post('maintenance_customer_type'),
			'maintenance_start'			=> $this->input->post('maintenance_start'),
			'maintenance_period'		=> $this->input->post('maintenance_period'),
			'maintenance_price'			=> str_replace(',', '', $this->input->post('maintenance_price')),
			'maintenance_markup'		=> str_replace(',', '', $this->input->post('maintenance_markup')),
			'maintenance_bank_id'		=> $this->input->post('maintenance_bank_id'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);
		
		if ($data['maintenance_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('maintenance_client_name'))->get('client')->row_array();
			$data['maintenance_client_id'] = $row['unique_id'];
		}
		elseif ($data['maintenance_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('maintenance_company_name'))->get('company')->row_array();
			$data['maintenance_company_id'] = $row['unique_id'];
		}
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'maintenance_name'			=> $this->input->post('maintenance_name'),
			'maintenance_customer_type'	=> $this->input->post('maintenance_customer_type'),
			'maintenance_start'			=> $this->input->post('maintenance_start'),
			'maintenance_period'		=> $this->input->post('maintenance_period'),
			'maintenance_price'			=> str_replace(',', '', $this->input->post('maintenance_price')),
			'maintenance_markup'		=> str_replace(',', '', $this->input->post('maintenance_markup')),
			'maintenance_bank_id'		=> $this->input->post('maintenance_bank_id'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);
		
		if ($data['maintenance_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('maintenance_client_name'))->get('client')->row_array();
			$data['maintenance_client_id'] = $row['unique_id'];
			$data['maintenance_company_id'] = 0;
		}
		elseif ($data['maintenance_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('maintenance_company_name'))->get('company')->row_array();
			$data['maintenance_company_id'] = $row['unique_id'];
			$data['maintenance_client_id'] = 0;
		}

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_maintenance.php */
/* Location: ./application/models/model_maintenance.php */