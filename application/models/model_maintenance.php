<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_maintenance extends CI_Model {

	public function list_data($where)
	{	
		$query = $this->db->select('m.unique_id, m.maintenance_name, maintenance_period, client_name, m.maintenance_price, m.maintenance_start, com.company_name, ban.bank_name, m.flag, m.memo')->select('DATE_ADD(m.maintenance_start, INTERVAL m.maintenance_period + m.maintenance_extend_month MONTH) as maintenance_end', false)->select('DATEDIFF(NOW(), DATE_ADD(m.maintenance_start, INTERVAL m.maintenance_period + m.maintenance_extend_month MONTH)) AS date_diff', false)->where($where)->join('company com', 'com.unique_id = m.maintenance_company_id', 'left')->join('client', 'client.unique_id = maintenance_client_id', 'left')->join('bank ban', 'ban.unique_id = m.maintenance_bank_id', 'left')->order_by('maintenance_end', 'ASC')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('maintenance.unique_id, maintenance_name, maintenance_customer_type, maintenance_company_id, maintenance_client_id, maintenance_start, maintenance_period, client_name AS maintenance_client_name, company_name AS maintenance_company_name, maintenance_price, maintenance_markup, maintenance_extend_counter, maintenance_extend_month, maintenance_bank_id, bank_currency, maintenance.flag, maintenance.memo')->join('company', 'company.unique_id = maintenance_company_id', 'left')->join('bank', 'bank.unique_id = maintenance_bank_id', 'left')->join('client', 'client.unique_id = maintenance_client_id', 'left')->where(array('maintenance.unique_id' => $unique_id))->get($this->db_table);
		return $query->row_array();
	}
	
	public function get_bank()
	{
		$query = $this->db->select('unique_id, bank_name, bank_account_holder, bank_account_number, bank_currency')->where('flag !=', 3)->get('bank');
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
	
	public function get_product()
	{
		$query = $this->db->select('unique_id, product_name, product_code')->where('flag !=', 3)->get('product');
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
	
	public function extend($unique_id)
	{
		$period = $this->input->post('maintenance_period');
		$price = str_replace(',', '', $this->input->post('maintenance_price')) * $period;
		$markup = str_replace(',', '', $this->input->post('maintenance_markup'));
		$total = $price + $markup;
		$invoice_number = generate_invoice_number($this->input->post('maintenance_bank_id'));
		
		$data = array(
			'unique_id'				=> get_unique_id('invoice'),
			'invoice_type'			=> 2,
			'invoice_item_id'		=> $unique_id,
			'invoice_customer_type'	=> $this->input->post('invoice_customer_type'),
			'invoice_number'		=> $invoice_number,
			'invoice_project_name'	=> $this->input->post('invoice_project_name'),
			'invoice_product_id'	=> $this->input->post('maintenance_product_id'),
			'invoice_price'			=> $price,
			'invoice_markup'		=> $markup,
			'invoice_commission'	=> '0', // Anggep sementara 0. Nanti default mau 5% dari PRICE kan?
			'invoice_top'			=> '1', // Karena extend, by default 1
			'invoice_top_number'	=> '1', // Karena extend, by default 1
			'invoice_top_percent'	=> '100', // Karena extend, default 100%
			'invoice_top_amount'	=> $total, // Total dari price + markup
			'invoice_bank_id'		=> $this->input->post('maintenance_bank_id'),
			'invoice_currency'		=> $this->input->post('bank_currency'),
			'invoice_create_date'	=> date('Y-m-d'),
			'invoice_note'			=> $this->input->post('invoice_note'),
			'flag'					=> 1
		);
		
		if ($data['invoice_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('maintenance_client_name'))->get('client')->row_array();
			$data['invoice_client_id'] = $row['unique_id'];
			$data['invoice_customer_name']= $this->input->post('maintenance_client_name');
		}
		elseif ($data['invoice_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('maintenance_company_name'))->get('company')->row_array();
			$data['invoice_company_id'] = $row['unique_id'];
			$data['invoice_customer_name']= $this->input->post('maintenance_company_name');
		}
		
		$this->db->insert('invoice', $data);
		
		/* Update DHM */
		$maintenance_row = $this->get($unique_id);
		
		$update_maintenance = array(
			'maintenance_extend_counter'	=> $maintenance_row['maintenance_extend_counter'] + 1,
			'maintenance_extend_month'		=> $maintenance_row['maintenance_extend_month'] + $this->input->post('maintenance_period')
		);
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update('maintenance', $update_maintenance);
		
		// Get End Date
		$dhm = $this->db->select('DATE_ADD(maintenance_start, INTERVAL maintenance_period + maintenance_extend_month MONTH) as maintenance_end', false)->where('unique_id', $unique_id)->get('maintenance')->row_array();
		
		echo date('d M Y', strtotime($dhm['maintenance_end']));
	}
}


/* End of file model_maintenance.php */
/* Location: ./application/models/model_maintenance.php */