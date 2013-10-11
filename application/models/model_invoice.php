<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_invoice extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('invoice.unique_id, invoice_type, invoice_item_id, invoice_customer_name, invoice_project_name, invoice_number, invoice_price, invoice_markup, invoice_top, invoice_top_number, invoice_top_amount, product_code, bank_name, bank_account_holder, bank_account_number, invoice_currency, invoice_create_date, invoice_note, invoice.flag, invoice.memo')->join('bank', 'bank.unique_id = invoice_bank_id', 'left')->join('product', 'product.unique_id = invoice_product_id', 'left')->where('invoice.flag !=', 3)->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('invoice.unique_id, invoice_number, invoice_customer_name, invoice_project_name, invoice_price, invoice_markup, invoice_note, invoice_currency, invoice_top, invoice_top_number, invoice_top_amount, invoice_create_date, invoice.flag, invoice.memo, product_name, product_code, bank_name, bank_account_holder, bank_account_number')->join('product', 'product.unique_id = invoice_product_id', 'left')->join('bank', 'bank.unique_id = invoice_bank_id', 'left')->where('invoice.unique_id', $unique_id)->get($this->db_table);
		return $query->row_array();
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
			$query = $this->db->select('unique_id, project_name AS name')->where(array('flag !=' => 3))->get('project');
		}
		
		if ($type) return $query->result_array();
		else return false;
	}
	
	public function get_period($table, $item_id)
	{
		$query = $this->db->select($table . '_period AS period')->where('unique_id', $item_id)->get($table);
		return $query->row_array();
	}
	
	public function get_price($table, $item_id)
	{
		$query = $this->db->select($table . '_price AS price, ' . $table . '_markup AS markup, ' . $table . '_period AS period')->where('unique_id', $item_id)->get($table);
		return $query->row_array();
	}
	
	public function get_invoice($unique_id)
	{
		$query = $this->db->select('unique_id, invoice_number, invoice_create_date, invoice_note, flag, memo')->where(array('invoice_type' => 3, 'invoice_item_id' => $unique_id, 'flag !=' => 3))->get('invoice');
		return $query->result_array();
	}
	
	public function insert()
	{
		$data = array(
			'unique_id'				=> get_unique_id($this->db_table),
			'project_name'			=> $this->input->post('project_name'),
			'project_bank_id'		=> $this->input->post('project_bank_id'),
			'project_currency'		=> $this->input->post('project_currency'),
			'project_price'			=> str_replace(',', '', $this->input->post('project_price')),
			'project_markup'		=> str_replace(',', '', $this->input->post('project_markup')),
			'project_note'			=> $this->input->post('project_note'),
			'project_top'			=> count($this->input->post('project_top')),
			'project_customer_type'	=> $this->input->post('project_customer_type'),
			'project_product_id'	=> $this->input->post('project_product_id'),
			'project_sales_id'		=> $this->input->post('project_sales_id'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		if ($this->input->post('project_top_type') == 1) // Percent
		{
			$each = array();
			
			foreach ($this->input->post('project_top') as $item)
			{
				$each[] = ($data['project_price'] + $data['project_markup']) * $item / 100;
			}
			
			$data['project_top_value'] = implode(',', $each);
		}
		elseif ($this->input->post('project_top_type') == 2)
		{
			$value = array();
			
			foreach ($this->input->post('project_top') as $item)
			{
				$value[] = str_replace(',', '', $item);
			}
			
			$data['project_top_value'] = implode(',', $value);
		}
		
		if ($data['project_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('project_client_name'))->get('client')->row_array();
			$data['project_client_id'] = $row['unique_id'];
		}
		elseif ($data['project_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('project_company_name'))->get('company')->row_array();
			$data['project_company_id'] = $row['unique_id'];
		}
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
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
	
	public function create_invoice()
	{
		$post = $this->input->post();
		
		$invoice_number = 'AUTO GENERATE - TEMP';
		
		$additional = array(
			'unique_id'				=> get_unique_id('invoice'),
			'invoice_number'		=> $invoice_number,
			'invoice_create_date'	=> date('Y-m-d'),
			'flag'					=> 1
		);
		
		if ($post['invoice_customer_type'] == 1)
		{
			$row = $this->db->select('unique_id')->where('client_name', $this->input->post('invoice_customer_name'))->get('client')->row_array();
			$additional['invoice_client_id'] = $row['unique_id'];
		}
		elseif ($data['project_customer_type'] == 2)
		{
			echo 'b';
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('invoice_customer_name'))->get('company')->row_array();
			$additional['invoice_company_id'] = $row['unique_id'];
		}
		
		$data = array_merge($post, $additional);
		
		$this->db->insert('invoice', $data);
		
		$readable_date = array('readable_date' => date('d M Y'));
		
		$result = array_merge($data, $readable_date);
		
		echo json_encode($result);
	}
}


/* End of file model_invoice.php */
/* Location: ./application/models/model_invoice.php */