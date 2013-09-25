<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('file_upload'))
{
	function file_upload($field_name, $allowed_types, $target_folder, $debug = FALSE)
	{
		$ci =& get_instance();

		if ( ! $_FILES[$field_name]['name']) return false;
		
		$config = array(
			'upload_path'	=> 'upload/' . $target_folder,
			'allowed_types'	=> $allowed_types
		);
		
		if ( ! file_exists($config['upload_path']))
		{
			mkdir($config['upload_path']);
		}
		
		$ci->load->library('upload');
		$ci->upload->initialize($config);
		
		if ( ! $ci->upload->do_upload($field_name))
		{
			if ($debug == TRUE) return $ci->upload->display_errors();
		}
		else
		{
			return $ci->upload->data();
		}
	}
}

if ( ! function_exists('remove_file'))
{
	function remove_file($db_name, $column_name, $unique_id, $target_folder)
	{
		$ci =& get_instance();
		
		$file_directory = 'upload/' . $target_folder;
		$trash_folder = 'trash/' . $target_folder;
		
		$row = $ci->db->select($column_name)->where('unique_id', $unique_id)->get($db_name)->row_array();
		
		print_r($row);
		
		if ($row)
		{
			if ($row[$column_name])
			{
				if ( ! file_exists($trash_folder))
				{
					mkdir($trash_folder);
				}
				
				if (file_exists($file_directory . '/' . $row[$column_name]))
				{
					rename($file_directory . '/' . $row[$column_name], $trash_folder . '/' . $row[$column_name]);
				}
			}
		}
	}
}


/* End of file upload_helper.php */
/* Location: ./application/helpers/upload_helper.php */