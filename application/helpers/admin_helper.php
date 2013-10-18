<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('spellnumber'))
{
	function spellnumber($number)
	{
	$number = strval($number);
	if (!preg_match('/^[0-9]{1,15}$/', $number)) 
		return(false); 
	$ones = array("", "one", "two", "three", "four", 
		"five", "six", "seven", "eight", "nine");
	$teens = array("ten", "eleven", "twelve", "thirteen", "fourteen", 
		"fifteen", "sixteen", "seventeen", "eighteen", "nineteen");
	$tens = array("", "", "twenty", "thirty", "forty", 
		"fifty", "sixty", "seventy", "eighty", "ninety");
	$majorUnits = array("", "thousand", "million", "billion", "trillion");
	$result = "";
	$isAnyMajorUnit = false;
	$length = strlen($number);
	for ($i = 0, $pos = $length - 1; $i < $length; $i++, $pos--) {
		if ($number{$i} != '0') {
			if ($pos % 3 == 0)
				$result .= $ones[$number{$i}] . ' ';
			else if ($pos % 3 == 1) {
				if ($number{$i} == '1') {
					$result .= $teens[$number{$i + 1}] . ' ';
					$i++; $pos--;
				} else {
					$result .= $tens[$number{$i}];
					$result .= $number{$i + 1} == '0'? ' ' : '-';
				}
			} else 
				$result .= $ones[$number{$i}] . " hundred ";
			$isAnyMajorUnit = true;
		}
		if ($pos % 3 == 0 && $isAnyMajorUnit) {
			$result .= $majorUnits[$pos / 3] . ' ';
			$isAnyMajorUnit = false;
		}
	}
	$result = trim($result);
	if ($result == "") $result = "zero";
	return($result);
	}
}

if ( ! function_exists('terbilang'))
{
	function terbilang ($number) {
		$number = strval($number);
		if (!preg_match('/^[0-9]{1,15}$/', $number)) 
			return(false); 
		$ones = array("", "satu", "dua", "tiga", "empat", 
			"lima", "enam", "tujuh", "delapan", "sembilan");
		$majorUnits = array("", "ribu", "juta", "milyar", "trilyun");
		$minorUnits = array("", "puluh", "ratus");
		$result = "";
		$isAnyMajorUnit = false;
		$length = strlen($number);
		for ($i = 0, $pos = $length - 1; $i < $length; $i++, $pos--) {
			if ($number{$i} != '0') {
				if ($number{$i} != '1')
					$result .= $ones[$number{$i}].' '.$minorUnits[$pos % 3].' ';
				else if ($pos % 3 == 1 && $number{$i + 1} != '0') {
					if ($number{$i + 1} == '1') 
						$result .= "sebelas "; 
					else 
						$result .= $ones[$number{$i + 1}]." belas ";
					$i++; $pos--;
				} else if ($pos % 3 != 0)
					$result .= "se".$minorUnits[$pos % 3].' ';
				else if ($pos == 3 && !$isAnyMajorUnit)
					$result .= "se";
				else
					$result .= "satu ";
				$isAnyMajorUnit = true;
			}
			if ($pos % 3 == 0 && $isAnyMajorUnit) {
				$result .= $majorUnits[$pos / 3].' ';
				$isAnyMajorUnit = false;
			}
		}
		$result = trim($result);
		if ($result == "") $result = "nol";
		return($result);
	}
}

if ( ! function_exists('namapt'))
{
	function namapt($str)
	{
		$break = strpbrk($str, ',');
		
		$baru = str_replace($break, '', $str);	
		
		$nama = trim(str_replace(',', '', $break));
		
		if ($break)
			return $nama . '. ' . $baru;
		else return $str;
	}
}

if ( ! function_exists('generate_invoice_number'))
{
	function generate_invoice_number($type = '')
	{
		$ci =& get_instance();
		$month = date('m');
		$year = date('Y'); 
		
		$month_code = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L');
		
		$count = '';
		
		if ($type == 1) // PT. Go Online Solusi
		{
			$prefix = 'PTGO';
			
			$query = $ci->db->select('COUNT(unique_id) AS total')->where(array('invoice_bank_id' => 1, 'flag !=' => 3))->get('invoice');
		}
		else // Wilson Iwan
		{
			$prefix = 'GO';
			
			$query = $ci->db->select('COUNT(unique_id) as total')->where(array('invoice_bank_id !=' => 1, 'flag !=' => 3))->get('invoice');
		}
		
		$row = $query->row_array();
		
		$count = ($row['total'] == 0) ? 1 : $row['total'] + 1;
		
		$invoice = $prefix . '/' . $month_code[$month] . '-' . $year . '/' . $count;
		
		return $invoice;
	}
}

if ( ! function_exists('default_checked'))
{
	function default_checked($fieldname, $row, $value)
	{
		$set_value = set_value($fieldname);
		if (empty($set_value))
		{
			if ($row[$fieldname] == $value) echo 'checked="checked"';
		}
		else
		{
			if ($set_value == $value) echo 'checked="checked"';
		}
	}
}

if ( ! function_exists('default_selected'))
{
	function default_selected($fieldname, $row, $value)
	{
		$set_value = set_value($fieldname);
		if (empty($set_value))
		{
			if ($row[$fieldname] == $value) echo 'selected="selected"';
		}
		else
		{
			if ($set_value == $value) echo 'selected="selected"';
		}
	}
}

if ( ! function_exists('form_value'))
{
	function form_value($field_name, $row)
	{
		return (set_value($field_name)) ? set_value($field_name) : $row[$field_name];
	}
}

if ( ! function_exists('check_admin_login'))
{
	function check_admin_login($result = '')
	{
		$ci =& get_instance();
		
		if ($result == 'redirect')
		{
			if ($ci->session->userdata('admin_logged_in') == FALSE)
			{
				$ci->session->set_flashdata('login_form_message', '<strong>Please login first</strong>');
				redirect(base_url('admin'));
			}
		}
		else
		{
			if ($ci->session->userdata('admin_logged_in') == FALSE)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
}

if ( ! function_exists('table_end'))
{
	function table_end($row)
	{
		if ($row['flag'] == 1)
		{
			$class = 'active';
		}
		elseif ($row['flag'] == 2)
		{
			$class = 'inactive';
		}
		
		echo '<td class="status"><span class="flag ' . $class . '"></span><img src="' . base_url('images/ajax-loader.gif') . '" /></td>';
        echo '<td class="memo">' . $row['memo'] . '</td>';
		
		$attr = (isset($row['invoice_type']) && $row['invoice_type'] == 3) ? ' attr="' . $row['invoice_item_id'] . '"' : '';// Project only
		echo '<td class="del"' . $attr . '><input type="checkbox" /></td>';
	}
}

if ( ! function_exists('get_unique_id'))
{
	function get_unique_id($db_table)
	{
		$ci =& get_instance();
		$query = $ci->db->select_max($db_table . '_id')->get($db_table);
		
		$row = $query->row_array();
		
		return ($row) ? $row[$db_table . '_id'] + 1 : 1;
	}
}

if ( ! function_exists('log_action'))
{
	function log_action($action = '', $db = '', $value = '', $description = '')
	{
		$ci =& get_instance();
		
		$data = array(
			'log_admin_id'		=> $ci->session->userdata('admin_id'),
			'log_action'		=> $action,
			'log_db'			=> $db,
			'log_value'			=> $value,
			'log_description'	=> $description,
			'log_ip'			=> $ci->input->ip_address(),
			'log_time'			=> date('Y-m-d H:i:s')
		);
		
		$ci->db->insert('log', $data);
	}
}

if ( ! function_exists('check_access'))
{
	function check_access($module_url, $access, $redirect = FALSE)
	{
		$ci =& get_instance();
		
		/* First, get logged-in admin details */
		$query = $ci->db->select('admin_privilege, admin_module_list, admin_module_access')->where('unique_id', $ci->session->userdata('admin_id'))->get('admin');
		$row = $query->row_array();
		
		if ($row['admin_privilege'] == 1)
		{
			return TRUE;
		}
		elseif ($row['admin_privilege'] == 2)
		{
			if ($access == 'add' || $access == 'edit' || $access == 'read' || $access == 'menu')
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		elseif ($row['admin_privilege'] == 3) /* Custom Privilege */
		{
		}
	}
	
	if ( ! function_exists('close_fancybox'))
	{
		function close_fancybox()
		{
			echo '<script type="text/javascript">parent.jQuery.fancybox.close("a");</script>';
		}
	}
}

/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */