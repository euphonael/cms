<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_company extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('company.unique_id, client_name, company_name, company_address, company_country, company_city, company_phone, company_email, company.flag, company.memo')->join('client', 'client.unique_id = company_client_id', 'left')->where('company.flag', 1)->get($this->db_table);
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('company_name, company_client_id, company_address, company_country, company_city, company_postal_code, company_phone, company_mobile, company_fax, company_email, m.flag, m.memo, client_name AS company_client_name')->where(array('m.unique_id' => $unique_id))->join('client f', 'company_client_id = f.unique_id', 'left')->get($this->db_table . ' m');
		return $query->row_array();
	}
	
	public function get_client()
	{
		$query = $this->db->select('client_name')->order_by('client_name', 'ASC')->where('flag !=', 3)->get('client');
		return $query->result_array();
	}
	
	public function get_client_id()
	{
		if ($this->input->post('company_client_name'))
		{
			$query = $this->db->select('unique_id')->where(array('flag !=' => 3, 'client_name' => $this->input->post('company_client_name')))->get('client');
			$row = $query->row_array();
			
			if ($query->num_rows() != 0)
			{
				return array('id' => $row['unique_id'], 'result' => 'exist');
			}
			else
			{
				$data = array(
					'unique_id'		=> get_unique_id('client'),
					'client_name'	=> $this->input->post('company_client_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('client', $data);
				return array('id' => $data['unique_id'], 'result' => 'new');
			}
		}
		else
		{
			return array('id' => 0, 'result' => 'none');
		}
	}
	
	public function insert()
	{
		$company_client_id = $this->get_client_id();
		
		$data = array(
			'unique_id'				=> get_unique_id($this->db_table),
			'company_name'			=> $this->input->post('company_name'),
			'company_client_id'		=> $company_client_id['id'],
			'company_address'		=> $this->input->post('company_address'),
			'company_country'		=> $this->input->post('company_country'),
			'company_city'			=> $this->input->post('company_city'),
			'company_postal_code'	=> $this->input->post('company_postal_code'),
			'company_phone'			=> $this->input->post('company_phone'),
			'company_mobile'		=> $this->input->post('company_mobile'),
			'company_fax'			=> $this->input->post('company_fax'),
			'company_email'			=> $this->input->post('company_email'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		/* Update Company Info to Client Name */
		$this->db->where('unique_id', $company_client_id['id']);
		$this->db->update('client', array('client_company_id' => $data['unique_id']));
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{
		$company_client_id = $this->get_client_id();
		
		/* Kalo udah ga ada company, kita set supaya company sebelumnya ga ada PIC */
		$row = $this->get($unique_id);
		
		if ($company_client_id == 0)
		{
			echo 'a';
			$this->db->where('unique_id', $row['company_client_id']);
			$this->db->update('client', array('client_company_id' => 0));
		}
		else
		{			
			$this->db->where('client_company_id', $unique_id);
			$this->db->update('client', array('client_company_id' => 0));
			
			if ($company_client_id['result'] == 'new')
			{
				$this->db->where('unique_id', $company_client_id['id']);
				$this->db->update('client', array('client_company_id' => $unique_id));
			}
			elseif ($company_client_id['result'] == 'exist')
			{
				$this->db->where('unique_id', $row['company_client_id']);
				$this->db->update('client', array('client_company_id' => $unique_id));
			}
		}
		
		$data = array(
			'company_name'			=> $this->input->post('company_name'),
			'company_client_id'		=> $company_client_id['id'],
			'company_address'		=> $this->input->post('company_address'),
			'company_country'		=> $this->input->post('company_country'),
			'company_city'			=> $this->input->post('company_city'),
			'company_postal_code'	=> $this->input->post('company_postal_code'),
			'company_phone'			=> $this->input->post('company_phone'),
			'company_mobile'		=> $this->input->post('company_mobile'),
			'company_fax'			=> $this->input->post('company_fax'),
			'company_email'			=> $this->input->post('company_email'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_company.php */
/* Location: ./application/models/model_company.php */