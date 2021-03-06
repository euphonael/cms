<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_project extends CI_Model {

	public function list_data($where)
	{
		$query = $this->db->select('project.unique_id, project_create_date, product_code, project_name, project_markup, project_top_value, project_price, project_invoice_count, project_top, project_top_value, company_name, client_name, bank_name, project.flag, project.memo, admin_name, product_name');
		$query = $this->db->where($where);
		
		$query = $this->db->join('company com', 'com.unique_id = project_company_id', 'left')->join('client', 'client.unique_id = project_client_id', 'left')->join('product', 'product.unique_id = project_product_id', 'left')->join('admin', 'admin.unique_id = project_sales_id', 'left')->join('bank ban', 'ban.unique_id = project_bank_id', 'left')->get($this->db_table);
		
		return $query->result_array();
		
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('project.unique_id, project_invoice_count, project_top_value, project_name, project_price, project_bank_id, project_sales_id, project_product_id, project_customer_type, project_markup, project_note, project_currency, client_name AS project_client_name, company_name AS project_company_name, project_top, project.flag, project.memo')->join('bank', 'bank.unique_id = project_bank_id', 'left')->join('company', 'company.unique_id = project_company_id', 'left')->join('client', 'client.unique_id = project_client_id', 'left')->where('project.unique_id', $unique_id)->get($this->db_table);
		return $query->row_array();
	}
	
	public function get_admin()
	{
		$query = $this->db->select('unique_id, admin_name')->order_by('admin_name', 'asc')->where(array('flag' => 1, 'admin_resign_date' => '0000-00-00'))->get('admin');
		return $query->result_array();
	}
	
	public function get_company()
	{
		$query = $this->db->select('unique_id, company_name')->where('flag !=', 3)->get('company');
		return $query->result_array();
	}
	
	public function get_client()
	{
		$query = $this->db->select('unique_id, client_name')->where('flag !=', 3)->get('client');
		return $query->result_array();
	}
	
	public function get_product()
	{
		$query = $this->db->select('unique_id, product_name, product_code')->where('flag !=', 3)->get('product');
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
	
	public function get_bank()
	{
		$query = $this->db->select('unique_id, bank_name, bank_account_holder, bank_account_number, bank_currency')->where('flag !=', 3)->get('bank');
		return $query->result_array();
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
			'project_create_date'	=> date('Y-m-d'),
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
			
			if ($row) $data['project_client_id'] = $row['unique_id'];
			else
			{
				$client = array(
					'unique_id'		=> get_unique_id('client'),
					'client_name'	=> $this->input->post('project_client_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('client', $client);
				$data['project_client_id'] = $this->db->insert_id();
			}
		}
		elseif ($data['project_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('project_company_name'))->get('company')->row_array();
			
			if ($row) $data['project_company_id'] = $row['unique_id'];
			else
			{
				$company = array(
					'unique_id'		=> get_unique_id('company'),
					'company_name'	=> $this->input->post('project_company_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('company', $company);
				$data['project_company_id'] = $this->db->insert_id();
			}
		}
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
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
			
			$data['project_company_id'] = 0;
			
			if ($row)
			{
				$data['project_client_id'] = $row['unique_id'];
			}
			else
			{
				$client = array(
					'unique_id'		=> get_unique_id('client'),
					'client_name'	=> $this->input->post('project_client_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('client', $client);
				$data['project_client_id'] = $this->db->insert_id();
			}
		}
		elseif ($data['project_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('project_company_name'))->get('company')->row_array();
			
			$data['project_client_id'] = 0;
			
			if ($row) $data['project_company_id'] = $row['unique_id'];
			else
			{
				$company = array(
					'unique_id'		=> get_unique_id('company'),
					'company_name'	=> $this->input->post('project_company_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('company', $company);
				$data['project_company_id'] = $this->db->insert_id();
			}
		}

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
	
	public function create_invoice()
	{
		$post = $this->input->post();
		
		$this_item = $this->db->select('project_bank_id')->where('unique_id', $post['invoice_item_id'])->get('project')->row_array();
		$invoice_number = generate_invoice_number($this_item['project_bank_id']);
		
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
		elseif ($post['invoice_customer_type'] == 2)
		{
			$row = $this->db->select('unique_id')->where('company_name', $this->input->post('invoice_customer_name'))->get('company')->row_array();
			$additional['invoice_company_id'] = $row['unique_id'];
		}
		
		$data = array_merge($post, $additional);
		
		$this->db->insert('invoice', $data);
		
		// Get current project (Invoice project id)
		
		$current = $this->db->select('project_invoice_count')->where('unique_id', $post['invoice_item_id'])->get('project')->row_array();
		
		$this->db->where('unique_id', $post['invoice_item_id']);
		$this->db->update('project', array('project_invoice_count' => $current['project_invoice_count'] + 1));
		
		$readable_date = array('readable_date' => date('d M Y'));
		
		$result = array_merge($data, $readable_date);
		
		echo json_encode($result);

	}
}


/* End of file model_project.php */
/* Location: ./application/models/model_project.php */