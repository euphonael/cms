<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_client extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, f.company_name, client_mobile, client_name, client_address, client_country, client_city, client_phone, client_email, m.flag, m.memo')->where('m.flag', 1)->join('company f', 'client_company_id = f.unique_id', 'left')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get_company()
	{
		$query = $this->db->select('company_name')->where('flag !=', 3)->order_by('unique_id', 'ASC')->get('company');
		
		return $query->result_array();
	}
	
	public function get($unique_id)
	{
		$query = $this->db->select('client_name, client_company_id, client_address, client_country, client_city, client_phone, client_postal_code, client_phone, client_mobile, client_fax, client_email, company_name AS client_company_name, m.flag, m.memo')->where(array('m.unique_id' => $unique_id))->join('company f', 'client_company_id = f.unique_id', 'left')->get($this->db_table . ' m');
		return $query->row_array();
	}
	
	public function get_company_id()
	{
		if ($this->input->post('client_company_name'))
		{
			$query = $this->db->select('unique_id')->where(array('flag !=' => 3, 'company_name' => $this->input->post('client_company_name')))->get('company');
			$row = $query->row_array();
			
			// Kalo udah ada
			if ($query->num_rows() != 0)
			{
				return array('id' => $row['unique_id'], 'result' => 'exist');
			}
			
			// Add new company
			else
			{
				$data = array(
					'unique_id'		=> get_unique_id('company'),
					'company_name'	=> $this->input->post('client_company_name'),
					'flag'			=> 1
				);
				
				$this->db->insert('company', $data);
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
		$client_company_id = $this->get_company_id();
		
		$data = array(
			'unique_id'				=> get_unique_id($this->db_table),
			'client_name'			=> $this->input->post('client_name'),
			'client_company_id'		=> $client_company_id['id'],
			'client_address'		=> $this->input->post('client_address'),
			'client_country'		=> $this->input->post('client_country'),
			'client_city'			=> $this->input->post('client_city'),
			'client_postal_code'	=> $this->input->post('client_postal_code'),
			'client_phone'			=> $this->input->post('client_phone'),
			'client_mobile'			=> $this->input->post('client_mobile'),
			'client_fax'			=> $this->input->post('client_fax'),
			'client_email'			=> $this->input->post('client_email'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		if ($client_company_id['result'] == 'new')
		{
			$this->db->where('unique_id', $client_company_id['id']);
			$this->db->update('company', array('company_client_id' => $data['unique_id']));
		}
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{
		$client_company_id = $this->get_company_id();
		
		/* Kalo udah ga ada company, kita set supaya company sebelumnya ga ada PIC */
		$row = $this->get($unique_id);
		if ($client_company_id['id'] == 0)
		{			
			$this->db->where('unique_id', $row['client_company_id']);
			$this->db->update('company', array('company_client_id' => 0));
		}
		else
		{
			$this->db->where('company_client_id', $unique_id);
			$this->db->update('company', array('company_client_id' => 0));
			
			$this->db->where('unique_id', $client_company_id['id']);
			$this->db->update('company', array('company_client_id' => $unique_id));
		}
		
		$data = array(
			'client_name'			=> $this->input->post('client_name'),
			'client_company_id'		=> $client_company_id['id'],
			'client_address'		=> $this->input->post('client_address'),
			'client_country'		=> $this->input->post('client_country'),
			'client_city'			=> $this->input->post('client_city'),
			'client_postal_code'	=> $this->input->post('client_postal_code'),
			'client_phone'			=> $this->input->post('client_phone'),
			'client_mobile'			=> $this->input->post('client_mobile'),
			'client_fax'			=> $this->input->post('client_fax'),
			'client_email'			=> $this->input->post('client_email'),
			'flag'					=> $this->input->post('flag'),
			'memo'					=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_client.php */
/* Location: ./application/models/model_client.php */