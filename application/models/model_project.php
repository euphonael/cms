<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_project extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('project.unique_id, project_name, project_markup, project_top_value, project_price, project_top, project_top_percent, company_name, client_name, bank_name, project.flag, project.memo, admin_name, product_name')->where('project.flag !=', 3)->join('company com', 'com.unique_id = project_company_id', 'left')->join('client', 'client.unique_id = project_client_id', 'left')->join('product', 'product.unique_id = project_product_id', 'left')->join('admin', 'admin.unique_id = project_sales_id', 'left')->join('bank ban', 'ban.unique_id = project_bank_id', 'left')->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('project.unique_id, project_top_type, project_top_value, project_name, project_price, project_bank_id, project_sales_id, project_product_id, project_customer_type, project_markup, project_note, project_currency, client_name AS project_client_name, company_name AS project_company_name, project_top, project_top_percent, project.flag, project.memo')->join('bank', 'bank.unique_id = project_bank_id', 'left')->join('company', 'company.unique_id = project_company_id', 'left')->join('client', 'client.unique_id = project_client_id', 'left')->where('project.unique_id', $unique_id)->get($this->db_table);
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
			'project_top_type'		=> $this->input->post('project_top_type'),
			'project_top'			=> count($this->input->post('project_top')),
			'project_customer_type'	=> $this->input->post('project_customer_type'),
			'project_product_id'	=> $this->input->post('project_product_id'),
			'project_sales_id'		=> $this->input->post('project_sales_id'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		if ($data['project_top_type'] == 1)
		{
			$data['project_top_percent'] = implode(',', $this->input->post('project_top'));
		}
		elseif ($data['project_top_type'] == 2)
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
			'project_name'			=> $this->input->post('project_name'),
			'project_bank_id'		=> $this->input->post('project_bank_id'),
			'project_currency'		=> $this->input->post('project_currency'),
			'project_price'			=> str_replace(',', '', $this->input->post('project_price')),
			'project_markup'		=> str_replace(',', '', $this->input->post('project_markup')),
			'project_note'			=> $this->input->post('project_note'),
			'project_top_type'		=> $this->input->post('project_top_type'),
			'project_top'			=> count($this->input->post('project_top')),
			'project_customer_type'	=> $this->input->post('project_customer_type'),
			'project_product_id'	=> $this->input->post('project_product_id'),
			'project_sales_id'		=> $this->input->post('project_sales_id'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		if ($data['project_top_type'] == 1)
		{
			$data['project_top_percent'] = implode(',', $this->input->post('project_top'));
		}
		elseif ($data['project_top_type'] == 2)
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

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_project.php */
/* Location: ./application/models/model_project.php */