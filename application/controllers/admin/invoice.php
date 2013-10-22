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
			'css'	=> array('jquery.fancybox', 'alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('jquery.fancybox.pack', 'alertify', 'jquery.dataTables.min', 'admin/list')
		);
		
		foreach ($this->model_invoice->get_client() as $item)
		{
			$client_list[] = $item['client_name'];
		}
		
		$data['client_list'] = (isset($client_list)) ? json_encode($client_list) : array();
		
		foreach ($this->model_invoice->get_company() as $item)
		{
			$company_list[] = $item['company_name'];
		}
		
		$data['company_list'] = (isset($company_list)) ? json_encode($company_list) : array();
		
		if ($this->input->post('flag')) $where = "invoice.flag = '" . $this->input->post('flag') . "'";
		else $where = "invoice.flag = 1";
		
		if ($this->input->post('customer_type'))
		{
			$where .= " AND invoice_customer_type = '" . $this->input->post('customer_type') . "'";
			
			if ($this->input->post('customer_type') == 1)
			{
				// Get client id
				$client = $this->model_invoice->get_client_id($this->input->post('client'));
				$where .= " AND invoice_client_id = '" . $client['unique_id'] . "'";
			}
			elseif ($this->input->post('customer_type') == 2)
			{
				// Get company id
				$company = $this->model_invoice->get_company_id($this->input->post('company'));
				$where .= " AND invoice_company_id = '" . $company['unique_id'] . "'";
			}
		}
		
		if ($this->input->post('start'))
		{
			if ( ! $this->input->post('end'))
				$where .= " AND invoice_create_date = '" . $this->input->post('start') . "'";
			
			elseif ($this->input->post('end'))
			{
				$where .= " AND invoice_create_date >= '" . $this->input->post('start') . "'";
				$where .= " AND invoice_create_date <= '" . $this->input->post('end') . "'";
			}
		}
		
		$having1 = '';
		$having2 = '';
		if ($this->input->post('amount'))
		{	
			$having1 .= "SUM(invoice_top_amount) >= " . $this->input->post('amount_start') . "";
			$having2 .= "SUM(invoice_top_amount) <= " . $this->input->post('amount_end') . "";
		}
		
		
		if ($this->input->post('product'))
		{
			$where .= " AND invoice_product_id = '" . $this->input->post('product') . "'";
		}
		
		if ( ! $this->input->post('payment'))
		{
			$where .= " AND invoice_paid = 0";
		}
		else
		{
			if ($this->input->post('payment') == 1)
			{
				$where .= " AND invoice_paid = 1";
			}
			elseif ($this->input->post('payment') == 2)
			{
				$where .= " AND invoice_paid = 0";
			}
		}
		
		#echo $where;

		$db_query = $this->model_invoice->list_data($where, $having1, $having2);
		
		$data['product_list'] = $this->model_invoice->get_product();
		$data['result'] = $db_query;
		$data['countmax'] = $this->model_invoice->list_data('invoice.flag != 3');

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
			'css'	=> array('jquery.fancybox', 'alertify.core', 'alertify.bootstrap', 'jquery.dataTables'),
			'js'	=> array('jquery.fancybox.pack', 'alertify', 'admin/form', 'jquery.dataTables.min', 'admin/list')
		);
		
		$data['Row'] = $this->model_invoice->get($unique_id);
		
		if ( ! $data['Row']) redirect(base_url('admin/' . $this->url));
		
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
		
		echo '<select name="invoice_item_id[]" class="invoice_item_id">';
		
		echo '<option value="">--</option>';
		
		if ($result)
		{
			foreach ($result as $item)
			{
				echo '<option value="' . $item['unique_id'] . '">' . $item['name'] . '</option>';
			}
		}
		
		echo '</select>';
	}
	
	public function get_product($type = '')
	{
		$result = $this->model_invoice->get_product();
		
		echo '<select name="invoice_product_id[]" class="invoice_product_id">';
		echo '<option value="">--</option>';
		
		foreach ($result as $item)
		{
			echo '<option value="' . $item['unique_id'] . '">' . $item['product_code'] . ' ' . $item['product_name'] . '</option>';
		}
		
		echo '</select>';
	}
	
	public function get_period($invoice_type, $item_id)
	{
		$html = '';
		
		if ($invoice_type == 1) $table = 'dhm';
		elseif ($invoice_type == 2) $table = 'maintenance';
		
		if ($invoice_type != 3)
		{
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
		}
		
		echo $html;
	}
	
	public function get_price($invoice_type, $item_id, $type = 'price')
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
			$suffix = '';
		}
		elseif ($invoice_type == 3)
		{
			$table = 'project';
			$suffix = '';
		}
		
		$period = $this->model_invoice->get_price($table, $item_id);
		
		if ($type == 'price') echo '<span>' . number_format($period[$type]) . $suffix . '</span>';
		else echo '<span>' . number_format($period[$type]) . '</span>';

	}
	
	public function get_top($item_id)
	{
		echo $this->model_invoice->get_top($item_id);
		echo '<input type="hidden" name="period[]" value="project" />';
	}
	
	public function pay($unique_id, $source = 'list')
	{
		$data = array(
			'title'		=> 'Pay ' . $this->title,
			'css'		=> array(),
			'js'		=> array('admin/form'),
			'source'	=> $source
		);
		
		$data['row'] = $this->model_invoice->get($unique_id);
		
		if ( ! $data['row']) redirect(base_url('admin/' . $this->url));
		
		$this->form_validation->set_rules('invoice_paid_date', 'payment date', 'trim|required');
		$this->form_validation->set_rules('invoice_paid_note', 'payment note', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/template/header', $data);
			$this->load->view('admin/' . $this->url . '/' . $this->url . '_payment');
			$this->load->view('admin/template/footer');
		}
		else
		{
			$result = $this->model_invoice->pay($unique_id);
			echo date('d M Y', strtotime($result['invoice_paid_date']));
		}
	}
	
	public function add_item($current)
	{
		$new = $current + 1;
		
		echo '<tr class="invoice-item">';
		echo '<td>' . $new . '</td>';
		echo '<td>';
		echo '<select name="invoice_type[]" class="invoice_type">';
		echo '<option value="">--</option>';
		echo '<option value="1">DHM</option>';
		echo '<option value="2">Maintenance</option>';
		echo '<option value="3">Project</option>';
		echo '</select>';
		echo '</td>';
		echo '<td>';
		echo '<select name="invoice_item_id[]" class="invoice_item_id">	';
		echo '<option value="">--</option>';
		echo '</select>';
		echo '</td>';
		echo '<td>';
		echo '<select name="invoice_product_id[]" class="invoice_product_id">';
		echo '<option value="">--</option>';
		echo '</select>';
		echo '</td>';
		echo '<td class="period"></td>';
		echo '<td class="price"></td>';
		echo '<td class="markup"></td>';
		echo '</tr>';
	}
	
	public function print_invoice($unique_id)
	{	
		$invoice = $this->model_invoice->get($unique_id);
		
		if ($invoice[0]['invoice_customer_type'] == 1) $type = 'client';
		else $type = 'company';
		
		$customer = $this->db->get_where($type, array('unique_id' => $invoice[0]['invoice_' . $type . '_id']))->row_array();
		
		$data = array(
			'row'	=> $invoice,
			'cust'	=> $customer,
			'type'	=> $type
		);

		$this->load->view('admin/invoice/print_invoice', $data);
	}
	
	public function print_receipt($unique_id)
	{	
		$invoice = $this->model_invoice->get($unique_id);
		
		if ($invoice[0]['invoice_customer_type'] == 1) $type = 'client';
		else $type = 'company';
		
		$customer = $this->db->get_where($type, array('unique_id' => $invoice[0]['invoice_' . $type . '_id']))->row_array();
		
		$data = array(
			'row'	=> $invoice,
			'cust'	=> $customer,
			'type'	=> $type
		);

		$this->load->view('admin/invoice/print_receipt', $data);
	}
}


/* End of file invoice.php */
/* Location: ./application/controllers/admin/invoice.php */