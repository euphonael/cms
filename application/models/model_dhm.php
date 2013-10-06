<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dhm extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, m.dhm_name, m.dhm_price, m.dhm_start, client_name, com.company_name, dom.domain_name, hos.hosting_name, ban.bank_name, m.flag, m.memo')->select('DATE_ADD(m.dhm_start, INTERVAL m.dhm_period + m.dhm_extend_month MONTH) as dhm_end', false)->select('DATEDIFF(NOW(), DATE_ADD(m.dhm_start, INTERVAL m.dhm_period + m.dhm_extend_month MONTH)) AS date_diff', false)->where('m.flag !=', 3)->join('company com', 'com.unique_id = m.dhm_company_id', 'left')->join('domain dom', 'dom.unique_id = m.dhm_domain_id', 'left')->join('hosting hos', 'hos.unique_id = m.dhm_hosting_id', 'left')->join('client', 'client.unique_id = dhm_client_id', 'left')->join('bank ban', 'ban.unique_id = m.dhm_bank_id', 'left')->order_by('dhm_end', 'ASC')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('dhm.unique_id, dhm_extend_counter, dhm_extend_month, company_name AS dhm_company_name, client_name AS dhm_client_name, dhm_name, dhm_customer_type, dhm_company_id, dhm_client_id, dhm_start, dhm_period, dhm_domain_id, bank_currency, dhm_hosting_id, dhm_price, dhm_markup, dhm_bank_id, dhm.flag, dhm.memo')->join('bank', 'bank.unique_id = dhm_bank_id', 'left')->join('company', 'company.unique_id = dhm_company_id', 'left')->join('client', 'client.unique_id = dhm_client_id', 'left')->where('dhm.unique_id', $unique_id)->get($this->db_table);
		return $query->row_array();
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
		$query = $this->db->select('unique_id, bank_name, bank_account_holder, bank_account_number, bank_currency')->where('flag !=', 3)->get('bank');
		return $query->result_array();
	}
	
	public function insert()
	{
		$data = array(
			'unique_id'			=> get_unique_id($this->db_table),
			'dhm_name'			=> $this->input->post('dhm_name'),
			'dhm_customer_type'	=> $this->input->post('dhm_customer_type'),
			'dhm_start'			=> $this->input->post('dhm_start'),
			'dhm_period'		=> $this->input->post('dhm_period'),
			'dhm_price'			=> str_replace(',', '', $this->input->post('dhm_price')),
			'dhm_markup'		=> str_replace(',', '', $this->input->post('dhm_markup')),
			'dhm_domain_id'		=> $this->input->post('dhm_domain_id'),
			'dhm_hosting_id'	=> $this->input->post('dhm_hosting_id'),
			'dhm_bank_id'		=> $this->input->post('dhm_bank_id'),
			'flag'				=> $this->input->post('flag'),
			'memo'				=> $this->input->post('memo')
		);
		
		if ($data['dhm_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('dhm_client_name'))->get('client')->row_array();
			$data['dhm_client_id'] = $row['unique_id'];
		}
		elseif ($data['dhm_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('dhm_company_name'))->get('company')->row_array();
			$data['dhm_company_id'] = $row['unique_id'];
		}
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'dhm_name'			=> $this->input->post('dhm_name'),
			'dhm_customer_type'	=> $this->input->post('dhm_customer_type'),
			'dhm_start'			=> $this->input->post('dhm_start'),
			'dhm_period'		=> $this->input->post('dhm_period'),
			'dhm_price'			=> str_replace(',', '', $this->input->post('dhm_price')),
			'dhm_markup'		=> str_replace(',', '', $this->input->post('dhm_markup')),
			'dhm_domain_id'		=> $this->input->post('dhm_domain_id'),
			'dhm_hosting_id'	=> $this->input->post('dhm_hosting_id'),
			'dhm_bank_id'		=> $this->input->post('dhm_bank_id'),
			'flag'				=> $this->input->post('flag'),
			'memo'				=> $this->input->post('memo')
		);
		
		if ($data['dhm_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('dhm_client_name'))->get('client')->row_array();
			$data['dhm_client_id'] = $row['unique_id'];
			$data['dhm_company_id'] = 0;
		}
		elseif ($data['dhm_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('dhm_company_name'))->get('company')->row_array();
			$data['dhm_company_id'] = $row['unique_id'];
			$data['dhm_client_id'] = 0;
		}

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
	
	public function extend($unique_id)
	{
		$price = str_replace(',', '', $this->input->post('dhm_price'));
		$markup = str_replace(',', '', $this->input->post('dhm_markup'));
		$total = $price + $markup;
		
		$data = array(
			'unique_id'				=> get_unique_id('invoice'),
			'invoice_type'			=> 1,
			'invoice_item_id'		=> $unique_id,
			'invoice_customer_type'	=> $this->input->post('invoice_customer_type'),
			'invoice_number'		=> 'Auto Generate - TEMP',
			'invoice_project_name'	=> $this->input->post('invoice_project_name'),
			'invoice_product_id'	=> '1', // Anggep aja ini DH01 (Domain Hosting)
			'invoice_price'			=> $price,
			'invoice_markup'		=> $markup,
			'invoice_commission'	=> '0', // Anggep sementara 0. Nanti default mau 5% dari PRICE kan?
			'invoice_top'			=> '1', // Karena extend, by default 1
			'invoice_top_number'	=> '1', // Karena extend, by default 1
			'invoice_top_percent'	=> '100', // Karena extend, default 100%
			'invoice_top_amount'	=> $total, // Total dari price + markup
			'invoice_bank_id'		=> $this->input->post('dhm_bank_id'),
			'invoice_currency'		=> $this->input->post('bank_currency'),
			'invoice_create_date'	=> date('Y-m-d'),
			'invoice_note'			=> $this->input->post('invoice_note'),
			'flag'					=> 1
		);
		
		if ($data['invoice_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('dhm_client_name'))->get('client')->row_array();
			$data['invoice_client_id'] = $row['unique_id'];
		}
		elseif ($data['invoice_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('dhm_company_name'))->get('company')->row_array();
			$data['invoice_company_id'] = $row['unique_id'];
		}
		
		$this->db->insert('invoice', $data);
		
		/* Update DHM */
		$dhm_row = $this->get($unique_id);
		
		$update_dhm = array(
			'dhm_extend_counter'	=> $dhm_row['dhm_extend_counter'] + 1,
			'dhm_extend_month'		=> $dhm_row['dhm_extend_month'] + $this->input->post('dhm_period')
		);
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update('dhm', $update_dhm);
		
		// Get End Date
		$dhm = $this->db->select('DATE_ADD(dhm_start, INTERVAL dhm_period + dhm_extend_month MONTH) as dhm_end', false)->where('unique_id', $unique_id)->get('dhm')->row_array();
		
		echo date('d M Y', strtotime($dhm['dhm_end']));
	}
}


/* End of file model_dhm.php */
/* Location: ./application/models/model_dhm.php */