<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_client extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('m.unique_id, f.company_name, client_name, client_address, client_country, client_city, client_phone, client_email, m.flag, m.memo')->where('m.flag !=', 3)->join('company f', 'client_company_id = f.unique_id', 'left')->get($this->db_table . ' m');
		
		return $query->result_array();
	}
	
	public function get_company()
	{
		$query = $this->db->select('unique_id, company_name')->where('flag !=', 3)->order_by('unique_id', 'ASC')->get('company');
		
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
			'client_name'			=> $this->input->post('client_name'),
			'client_company_id'		=> $this->input->post('client_company_id'),
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
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'client_name'			=> $this->input->post('client_name'),
			'client_company_id'		=> $this->input->post('client_company_id'),
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