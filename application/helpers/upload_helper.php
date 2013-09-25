<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('file_upload'))
{
	function file_upload($field_name, $allowed_types, $target_folder, $db_name, $unique_id = '', $debug = FALSE)
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
			if ($unique_id) remove_file($db_name, $field_name, $unique_id, $target_folder);
			return $ci->upload->data();
		}
	}
}

if ( ! function_exists('remove_file'))
{
	function remove_file($db_name, $field_name, $unique_id, $target_folder)
	{
		$ci =& get_instance();
		
		$file_directory = 'upload/' . $target_folder;
		$trash_folder = 'trash/' . $target_folder;
		
		$row = $ci->db->select($field_name)->where('unique_id', $unique_id)->get($db_name)->row_array();
		
		if ($row)
		{
			if ($row[$field_name])
			{
				if ( ! file_exists($trash_folder))
				{
					mkdir($trash_folder);
				}
				
				if (file_exists($file_directory . '/' . $row[$field_name]))
				{
					rename($file_directory . '/' . $row[$field_name], $trash_folder . '/' . $row[$field_name]);
				}
			}
		}
	}
}


/* End of file upload_helper.php */
/* Location: ./application/helpers/upload_helper.php */