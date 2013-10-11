<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends MY_Controller {

	var $title = 'Invoice';
	var $url = 'invoice';
	var $db_table = 'invoice';
	
	public function __construct()
	{
		parent::__construct();
		check_admin_login('redirect');
		$this->load->model('model_invoice');
	}	
	
	public function index()
	{
		$data = array(
			'title'	=> 'List ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list')
		);

		$db_query = $this->model_invoice->list_data();
		
		$data['result'] = $db_query;

		$this->show('admin/' . $this->url . '/list_' . $this->url, $data);
	}
	
	public function add()
	{
		$data = array(
			'title'	=> 'Add ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'jquery.dataTables.min', 'admin/list', 'admin/form')
		);

		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/add_' . $this->url, $data);
		}
		else
		{
			$this->model_invoice->insert();
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function view($unique_id)
	{
		$data = array(
			'title'	=> 'View ' . $this->title,
			'css'	=> array('alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('alertify', 'admin/form', 'jquery.dataTables.min', 'admin/list')
		);
		
		$data['row'] = $this->model_invoice->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$data['log'] = $this->model_invoice->get_log($unique_id);
		
		$this->form_validation->set_rules('flag', 'flag', 'required');
		$this->form_validation->set_rules('memo', 'memo', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->show('admin/' . $this->url . '/view_' . $this->url, $data);
		}
		else
		{
			$this->model_invoice->update($unique_id);
			redirect(base_url('admin/' . $this->url));
		}
	}
	
	public function add_log()
	{
		$this->model_invoice->add_log();
	}
	
	public function get_type($type = '')
	{
		$result = $this->model_invoice->get_type($type);
		
		echo '<option value="">--</option>';
		
		if ($result)
		{
			foreach ($result as $item)
			{
				echo '<option value="' . $item['unique_id'] . '">' . $item['name'] . '</option>';
			}
		}
	}
	
	public function get_product($type = '')
	{
		$result = $this->model_invoice->get_product();
		
		echo '<option value="">--</option>';
		
		foreach ($result as $item)
		{
			echo '<option value="' . $item['unique_id'] . '">' . $item['product_code'] . ' ' . $item['product_name'] . '</option>';
		}
	}
	
	public function get_period($invoice_type, $item_id)
	{
		$html = '';
		
		if ($invoice_type == 1) $table = 'dhm';
		elseif ($invoice_type == 2) $table = 'maintenance';
		
		$period = $this->model_invoice->get_period($table, $item_id);
		
		if ($invoice_type == 1) // DHM
		{
			$html .= '<select style="display:none;" name="period[]">';
			
			for ($x = 12; $x <= 60; $x += 12)
			{
				$sel = ($period['period'] == $x) ? ' selected="selected"' : '';
				$html .= '<option value="' . $x . '"' . $sel . '>' . $x . ' months</option>';
			}
			
			$html .= '</select>';
		}
		elseif ($invoice_type == 2) // Maintenance
		{
			$html .= '<p style="margin:0; display:none;"><input type="text" class="number-format" maxlength="3" name="period[]" value="' . $period['period'] . '" /> months</p>';
		}
		
		echo $html;
	}
	
	public function get_price($invoice_type, $item_id)
	{
		$html = '';
		
		if ($invoice_type == 1)
		{
			$table = 'dhm';
			$suffix = ' / year';
		}
		elseif ($invoice_type == 2)
		{
			$table = 'maintenance';
			$suffix = ' / month';
		}
		
		$period = $this->model_invoice->get_price($table, $item_id);
		
		echo '<span>' . number_format($period['price']) . $suffix . '</span>';
	}
}


/* End of file invoice.php */
/* Location: ./application/controllers/admin/invoice.php */