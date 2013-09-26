<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_company extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('unique_id, company_name, company_address, company_country, company_city, company_phone, company_email, flag, memo')->where('flag !=', 3)->get($this->db_table);
		
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
			'company_name'			=> $this->input->post('company_name'),
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
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'company_name'			=> $this->input->post('company_name'),
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