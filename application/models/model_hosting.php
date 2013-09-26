<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_hosting extends CI_Model {

	public function list_data()
	{	
		$query = $this->db->select('unique_id, hosting_name, hosting_root_domain, hosting_cpanel_url, hosting_cpanel_username, hosting_cpanel_password, hosting_disk_space, hosting_subdomain, hosting_addon_domain, hosting_mysql_db, hosting_expiry, flag, memo')->where('flag !=', 3)->get($this->db_table);
		
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
			'unique_id'					=> get_unique_id($this->db_table),
			'hosting_name'				=> $this->input->post('hosting_name'),
			'hosting_root_domain'		=> $this->input->post('hosting_root_domain'),
			'hosting_expiry'			=> $this->input->post('hosting_expiry'),
			'hosting_cpanel_url'		=> $this->input->post('hosting_cpanel_url'),
			'hosting_cpanel_username'	=> $this->input->post('hosting_cpanel_username'),
			'hosting_cpanel_password'	=> $this->input->post('hosting_cpanel_password'),
			'hosting_disk_space'		=> $this->input->post('hosting_disk_space'),
			'hosting_subdomain'			=> $this->input->post('hosting_subdomain'),
			'hosting_addon_domain'		=> $this->input->post('hosting_addon_domain'),
			'hosting_mysql_db'			=> $this->input->post('hosting_mysql_db'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);
		
		$this->db->insert($this->db_table, $data);
		
		log_action('INSERT', $this->db_table, $data['unique_id']);
	}
	
	public function update($unique_id)
	{		
		$data = array(
			'hosting_name'				=> $this->input->post('hosting_name'),
			'hosting_root_domain'		=> $this->input->post('hosting_root_domain'),
			'hosting_expiry'			=> $this->input->post('hosting_expiry'),
			'hosting_cpanel_url'		=> $this->input->post('hosting_cpanel_url'),
			'hosting_cpanel_username'	=> $this->input->post('hosting_cpanel_username'),
			'hosting_cpanel_password'	=> $this->input->post('hosting_cpanel_password'),
			'hosting_disk_space'		=> $this->input->post('hosting_disk_space'),
			'hosting_subdomain'			=> $this->input->post('hosting_subdomain'),
			'hosting_addon_domain'		=> $this->input->post('hosting_addon_domain'),
			'hosting_mysql_db'			=> $this->input->post('hosting_mysql_db'),
			'flag'						=> $this->input->post('flag'),
			'memo'						=> $this->input->post('memo')
		);

		$this->db->where('unique_id', $unique_id);
		$this->db->update($this->db_table, $data);
		
		log_action('UPDATE', $this->db_table, $unique_id);
	}
}


/* End of file model_hosting.php */
/* Location: ./application/models/model_hosting.php */