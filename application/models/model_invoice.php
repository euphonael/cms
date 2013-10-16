<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_invoice extends CI_Model {

	public function list_data($where, $having1 = '', $having2 = '')
	{	
		$query = $this->db->select('COUNT(invoice_top_amount) AS top_count, SUM(invoice_top_amount) AS total_top_amount, SUM(invoice_price) AS total_invoice_price, SUM(invoice_markup) AS total_invoice_markup, invoice.unique_id, invoice_paid, invoice_paid_date, invoice_type, invoice_item_id, invoice_customer_name, invoice_project_name, invoice_number, invoice_price, invoice_markup, invoice_top, invoice_top_number, invoice_top_amount, product_code, bank_name, bank_account_holder, bank_account_number, invoice_currency, invoice_create_date, invoice_note, invoice.flag, invoice.memo')->join('bank', 'bank.unique_id = invoice_bank_id', 'left')->group_by('invoice.unique_id')->join('product', 'product.unique_id = invoice_product_id', 'left');
		
		if ($having1) $query = $this->db->having($having1);
		if ($having2) $query = $this->db->having($having2);
		
		$query = $this->db->where($where);
		
		$query = $this->db->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('invoice_type, invoice_create_date, bank_branch, bank_currency, bank_swift_code, invoice_customer_type, invoice_company_id, invoice_client_id, invoice_paid, invoice_paid_date, invoice.unique_id, invoice_number, invoice_customer_name, invoice_project_name, invoice_price, invoice_markup, invoice_note, invoice_currency, invoice_top, invoice_top_number, invoice_top_amount, invoice_create_date, invoice.flag, invoice.memo, product_name, product_code, bank_name, bank_account_holder, bank_account_number')->join('product', 'product.unique_id = invoice_product_id', 'left')->join('bank', 'bank.unique_id = invoice_bank_id', 'left')->where('invoice.unique_id', $unique_id)->get($this->db_table);
		return $query->result_array();
	}
	
	public function get_admin()
	{
		$query = $this->db->select('unique_id, admin_name')->order_by('admin_name', 'asc')->where('flag !=', 3)->get('admin');
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
	
	public function get_bank()
	{
		$query = $this->db->select('unique_id, bank_name, bank_account_holder, bank_account_number, bank_currency')->where('flag !=', 3)->get('bank');
		return $query->result_array();
	}
	
		public function get_client_id($name)
	{
		$query = $this->db->select('unique_id')->where('client_name', $name)->get('client');
		return $query->row_array();
	}
	
	public function get_company_id($name)
	{
		$query = $this->db->select('unique_id')->where('company_name', $name)->get('company');
		return $query->row_array();
	}

	
	public function pay($unique_id)
	{
		$data = array(
			'invoice_paid'		=> 1,
			'invoice_paid_date'	=> $this->input->post('invoice_paid_date'),
			'invoice_paid_note'	=> $this->input->post('invoice_paid_note'),
		);
		
		$this->db->where('unique_id', $unique_id);
		$this->db->update('invoice', $data);
		
		$log = array(
			'unique_id'					=> get_unique_id('invoice_log'),
			'invoice_unique_id'			=> $unique_id,
			'invoice_log_admin_id'		=> $this->session->userdata('admin_id'),
			'invoice_log_admin_ip'		=> $this->input->ip_address(),
			'invoice_log_description'	=> 'Paid on: ' . date('d M Y H:i:s'),
			'invoice_log_datetime'		=> date('Y-m-d, H:i:s')
		);

		$this->db->insert('invoice_log', $log);
		
		return $data;
	}
	
	public function get_type($type = '')
	{
		if ($type == 1) // DHM
		{
			$query = $this->db->select('unique_id, dhm_name AS name')->where(array('flag !=' => 3, 'DATEDIFF(NOW(), DATE_ADD(dhm_start, INTERVAL dhm_period + dhm_extend_month MONTH)) >=' => '-30'))->get('dhm');
		}
		elseif ($type == 2) // Maintenance
		{
			$query = $this->db->select('unique_id, maintenance_name AS name')->where(array('flag !=' => 3, 'DATEDIFF(NOW(), DATE_ADD(maintenance_start, INTERVAL maintenance_period + maintenance_extend_month MONTH)) >=' => '-30'))->get('maintenance');
		}
		elseif ($type == 3)
		{
			$query = $this->db->select('unique_id, project_name AS name')->where(array('flag !=' => 3))->where('project_invoice_count < project_top', NULL, FALSE)->get('project');
		}
		
		if ($type) return $query->result_array();
		else return false;
	}
	
	public function get_period($table = '', $item_id)
	{
		$query = $this->db->select($table . '_period AS period')->where('unique_id', $item_id)->get($table);
		return $query->row_array();
	}
	
	public function get_price($table, $item_id)
	{
		if ($table != 'project')
		{
			$period = ', ' . $table . '_period AS period';
		}
		else
		{
			$period = ''; // table prokect
		}
		
		$query = $this->db->select($table . '_price AS price, ' . $table . '_markup AS markup' . $period)->where('unique_id', $item_id)->get($table);
		return $query->row_array();
	}
	
	public function get_top($item_id)
	{
		// Get project id
		$query = $this->db->select('project_invoice_count, project_top, project_top_value')->where('unique_id', $item_id)->get('project');
		$row = $query->row_array();
		
		$existing_invoice = $row['project_invoice_count'];
		$top = $row['project_top'];
		$value = explode(',', $row['project_top_value']);
		$current_top = $existing_invoice + 1;
		
		return '<span>' . number_format($value[$existing_invoice]) . ' (Payment ' . $current_top . ' / ' . $top . ')</span>';
	}
	
	public function get_invoice($unique_id)
	{
		$query = $this->db->select('unique_id, invoice_number, invoice_create_date, invoice_note, flag, memo')->where(array('invoice_type' => 3, 'invoice_item_id' => $unique_id, 'flag !=' => 3))->get('invoice');
		return $query->result_array();
	}
	
	public function insert()
	{
		$post = $this->input->post();
		
		$count = 0;
		foreach ($post['invoice_item_id'] as $foo)
		{
			if ($foo) $count++; // Jumlah invoice item
		}
		
		$unique_id = get_unique_id('invoice');

		for ($i = 0; $i <= $count; $i++)
		{
			if ($post['invoice_type'][$i])
			{
				$data = array(
					'unique_id'				=> $unique_id,
					'invoice_type'			=> $post['invoice_type'][$i],
					'invoice_item_id'		=> $post['invoice_item_id'][$i],
					'invoice_product_id'	=> $post['invoice_product_id'][$i],
					'invoice_create_date'	=> date('Y-m-d'),
					'flag'					=> 1
				);
				
				// Get type detail
				if ($data['invoice_type'] == 1)
				{
					$row = $this->db->get_where('dhm', array('unique_id' => $data['invoice_item_id']))->row_array();
					
					$detail = array(
						'invoice_customer_type' => $row['dhm_customer_type'],
						'invoice_client_id'		=> $row['dhm_client_id'],
						'invoice_company_id'	=> $row['dhm_company_id'],
						'invoice_project_name'	=> $row['dhm_name'] . ' ' . date('M Y'),
						'invoice_price'			=> $row['dhm_price'],
						'invoice_markup'		=> $row['dhm_markup'],
						'invoice_commission'	=> 0,
						'invoice_top'			=> 1,
						'invoice_top_number'	=> 1,
						'invoice_top_percent'	=> 100,
						'invoice_top_amount'	=> ($post['period'][$i] / 12 * $row['dhm_price']) + $row['dhm_markup'],
						'invoice_bank_id'		=> $row['dhm_bank_id'],
					);
					
					if ($row['dhm_customer_type'] == 1)
						$cust = $this->db->select('client_name AS name')->where('unique_id', $row['dhm_client_id'])->get('client')->row_array();
					elseif ($row['dhm_customer_type'] == 2)
						$cust = $this->db->select('company_name AS name')->where('unique_id', $row['dhm_company_id'])->get('company')->row_array();
	
					$currency = $this->db->select('bank_currency')->where('unique_id', $row['dhm_bank_id'])->get('bank')->row_array();
										
					$detail['invoice_customer_name'] = $cust['name'];
					$detail['invoice_currency'] = $currency['bank_currency'];
					
					$invoice_number = generate_invoice_number($detail['invoice_bank_id']);
					$data['invoice_number'] = $invoice_number;
					
					$final = array_merge($data, $detail);
					
					$this->db->insert('invoice', $final);
					
					// Extend DHM
					$this->db->where('unique_id', $data['invoice_item_id']);
					$this->db->update('dhm', array('dhm_extend_counter' => $row['dhm_extend_counter'] + 1, 'dhm_extend_month' => $row['dhm_extend_month'] + $post['period'][$i]));
				}
				
				elseif ($data['invoice_type'] == 2)
				{
					$row = $this->db->get_where('maintenance', array('unique_id' => $data['invoice_item_id']))->row_array();
					
					$detail = array(
						'invoice_customer_type' => $row['maintenance_customer_type'],
						'invoice_client_id'		=> $row['maintenance_client_id'],
						'invoice_company_id'	=> $row['maintenance_company_id'],
						'invoice_project_name'	=> $row['maintenance_name'] . ' ' . date('M Y'),
						'invoice_price'			=> $row['maintenance_price'],
						'invoice_markup'		=> $row['maintenance_markup'],
						'invoice_commission'	=> 0,
						'invoice_top'			=> 1,
						'invoice_top_number'	=> 1,
						'invoice_top_percent'	=> 100,
						'invoice_top_amount'	=> ($post['period'][$i] * $row['maintenance_price']) + $row['maintenance_markup'],
						'invoice_bank_id'		=> $row['maintenance_bank_id'],
					);
					
					if ($row['maintenance_customer_type'] == 1)
						$cust = $this->db->select('client_name AS name')->where('unique_id', $row['maintenance_client_id'])->get('client')->row_array();
					elseif ($row['maintenance_customer_type'] == 2)
						$cust = $this->db->select('company_name AS name')->where('unique_id', $row['maintenance_company_id'])->get('company')->row_array();
	
					$currency = $this->db->select('bank_currency')->where('unique_id', $row['maintenance_bank_id'])->get('bank')->row_array();
										
					$detail['invoice_customer_name'] = $cust['name'];
					$detail['invoice_currency'] = $currency['bank_currency'];

					$invoice_number = generate_invoice_number($detail['invoice_bank_id']);
					$data['invoice_number'] = $invoice_number;
					
					$final = array_merge($data, $detail);
					
					$this->db->insert('invoice', $final);
					
					// Extend Maintenance
					$this->db->where('unique_id', $data['invoice_item_id']);
					$this->db->update('maintenance', array('maintenance_extend_counter' => $row['maintenance_extend_counter'] + 1, 'maintenance_extend_month' => $row['maintenance_extend_month'] + $post['period'][$i]));
				}
				elseif ($data['invoice_type'] == 3)
				{
					$row = $this->db->get_where('project', array('unique_id' => $data['invoice_item_id']))->row_array();
					
					$amount = explode(',', $row['project_top_value']);
					
					$detail = array(
						'invoice_customer_type' => $row['project_customer_type'],
						'invoice_client_id'		=> $row['project_client_id'],
						'invoice_company_id'	=> $row['project_company_id'],
						'invoice_project_name'	=> $row['project_name'],
						'invoice_price'			=> $row['project_price'],
						'invoice_markup'		=> $row['project_markup'],
						'invoice_commission'	=> 0,
						'invoice_top'			=> $row['project_top'],
						'invoice_top_number'	=> $row['project_invoice_count'] + 1,
						'invoice_top_amount'	=> $amount[$row['project_invoice_count']],
						'invoice_bank_id'		=> $row['project_bank_id'],
					);
					
					if ($row['project_customer_type'] == 1)
						$cust = $this->db->select('client_name AS name')->where('unique_id', $row['project_client_id'])->get('client')->row_array();
					elseif ($row['project_customer_type'] == 2)
						$cust = $this->db->select('company_name AS name')->where('unique_id', $row['project_company_id'])->get('company')->row_array();
	
					$currency = $this->db->select('bank_currency')->where('unique_id', $row['project_bank_id'])->get('bank')->row_array();
										
					$detail['invoice_customer_name'] = $cust['name'];
					$detail['invoice_currency'] = $currency['bank_currency'];
					
					$invoice_number = generate_invoice_number($detail['invoice_bank_id']);
					$data['invoice_number'] = $invoice_number;
					
					$final = array_merge($data, $detail);
					
					
					$this->db->insert('invoice', $final);
					
					// Update Project Invoice Count
					$this->db->where('unique_id', $data['invoice_item_id']);
					$this->db->update('project', array('project_invoice_count' => $row['project_invoice_count'] + 1));
				}
			}
		}
		
		
		
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
	
	public function get_log($unique_id)
	{
		$query = $this->db->select('invoice_log_admin_ip, invoice_log_description, invoice_log_datetime, admin_name')->join('admin', 'admin.unique_id = invoice_log_admin_id', 'left')->order_by('invoice_log_datetime', 'ASC')->where('invoice_unique_id', $unique_id)->get('invoice_log');
		return $query->result_array();
	}
	
	public function add_log()
	{
		$data = array(
			'unique_id'					=> get_unique_id('invoice_log'),
			'invoice_unique_id'			=> $this->input->post('invoice_unique_id'),
			'invoice_log_admin_id'		=> $this->session->userdata('admin_id'),
			'invoice_log_admin_ip'		=> $this->input->ip_address(),
			'invoice_log_description'	=> trim($this->input->post('invoice_log_description')),
			'invoice_log_datetime'		=> date('Y-m-d H:i:s')
		);
		
		if ($data['invoice_log_description'])
		{
			$this->db->insert('invoice_log', $data);
			log_action('INSERT', 'invoice_log', $data['unique_id']);
			echo 'success';
		}
		else echo 'fail';
	}
}


/* End of file model_invoice.php */
/* Location: ./application/models/model_invoice.php */