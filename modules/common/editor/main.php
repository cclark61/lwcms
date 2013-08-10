<?php
//***************************************************************************
/**
* LWCMS (Lightweight Content Mangement System)
*
* @package		LWCMS
* @author 		Christian J. Clark
* @copyright	Copyright (c) Christian J. Clark
* @license		http://www.gnu.org/licenses/gpl-2.0.txt
* @link			http://www.emonlade.net/lwcms/
**/
//***************************************************************************

//==================================================================
// Images
//==================================================================
$open_folder_image = image("{$icon_base_dir}/folder_go.png", "Open", array("title" => "Open Directory"));
$add_file_image = image("{$icon_base_dir}/page_white_add.png", "[+]", array("title" => "Add", "class" => "gen_icon"));
$del_file_image = image("{$icon_base_dir}/page_white_delete.png", "[+]", array("title" => "Delete File", "class" => "gen_icon"));
$add_folder_image = image("{$icon_base_dir}/folder_add.png", "[+]", array("title" => "Add", "class" => "gen_icon"));
$del_folder_image = image("{$icon_base_dir}/folder_delete.png", "[-]", array("title" => "Delete Folder", "class" => "gen_icon"));
$upload_file_image = image("{$icon_base_dir}/drive_add.png", "[^]", array("title" => "Upload File", "class" => "gen_icon"));

//==================================================================
// Top Module Links
//==================================================================
if ($acc_lvl > 1) {
	$top_mod_links = array();
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
	$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Create a new file", "image" => xml_escape($add_file_image));
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add_dir"), true);
	$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Create new a Folder", "image" => xml_escape($add_folder_image));
	$tmp_link = add_url_params($mod_base_url2, array("action" => "upload_file"), true);
	$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Upload a File", "image" => xml_escape($upload_file_image));
}

//==================================================================
// Display Files and Folders
//==================================================================
$dir_list = array();
foreach($dir_files as $key => $df) {
	if ($df == "." || $df == '..') { continue; }
	$tmp_item = array();
	$tmp_item["id"] = $key;
	$tmp_item["name"] = $df;
	$encoded_name = base64_encode($df);
	$encoded_dir = ($disp_curr_dir != '') ? (base64_encode("{$disp_curr_dir}/{$df}")) : (base64_encode($df));
	$tmp_path = $curr_dir . "/" . $df;
	$tmp_item["type"] = (is_dir($tmp_path)) ? ("dir") : ("file");
	$tmp_item["size"] = ($tmp_item["type"] == "file") ? (format_filesize(filesize($tmp_path))) : ("--");

	//--------------------------------------------------------
	// Files
	//--------------------------------------------------------
	if ($tmp_item["type"] == "file") {
		$file_ext_parts = explode(".", $df);
		$fp_size = count($file_ext_parts);
		if ($fp_size < 2) { $file_ext = 'txt'; }
		else if ($fp_size > 0 && $file_ext_parts[0] == '') { $file_ext = 'txt'; }
		else { $file_ext = $file_ext_parts[$fp_size - 1]; }

		// Defualts
		$editable = false;
		$tmp_image = "page_white.png";
		$alt = "File";
		
		switch ($file_ext) {
			case "php":
				$editable = true;
				$tmp_image = "page_white_php.png";
				$alt = "PHP Code";
				break;

			case "xsl":
			case "xml":
				$editable = true;
				$tmp_image = "tag.png";
				$alt = "XML Document";
				break;

			case "html":
			case "xhtml":
				$editable = true;
				$tmp_image = "html.png";
				$alt = "HTML Code";
				break;

			case "css":
				$editable = true;
				$tmp_image = "css.png";
				$alt = "Cascading Stylesheet";
				break;

			case "js":
			case "javascript":
				$editable = true;
				$tmp_image = "script.png";
				$alt = "Javascript";
				break;

			case "ico":
			case "jpg":
			case "gif":
			case "png":
			case "tiff":
			case "psd":
			case "bmp":
				$tmp_image = "photo.png";
				$alt = "Image";
				break;

			case '':
			case 'txt':
			case 'conf':
			case 'cnf':
			case 'ini':
				$editable = true;
				$alt = "Text Document";
				break;

			default:
				$editable = false;
				$alt = "Text Document";
				break;

		}
		
		$tmp_image = image("{$icon_base_dir}/$tmp_image", false, array("title" => $alt));
		$tmp_item["name"] = $tmp_image . $df;

		if ($editable && is_writeable($tmp_path)) {
			$edit_link = add_url_params($mod_base_url, array("action" => "edit", "file" => $encoded_name));
			$tmp_item["name"] = anchor($edit_link, $tmp_item["name"]);
		}
		$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "file" => $encoded_name));
		$tmp_item["delete"] = anchor($delete_link, $del_file_image, array('class' => 'btn'));

	}
	//--------------------------------------------------------
	// Folders
	//--------------------------------------------------------
	else {
		$tmp_image = image("{$icon_base_dir}/folder.png", "Directory", array("title" => "Directory"));
		$editable = false;
		$folder_base_url = "{$mod_home_url}{$encoded_dir}/";

		$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete2", "folder" => $encoded_dir));
		$tmp_item["delete"] = anchor($delete_link, $del_folder_image, array('class' => 'btn'));
		$tmp_item["name"] = anchor($folder_base_url, $tmp_image . $df);
	}

	//--------------------------------------------------------
	// Add Array to list
	//--------------------------------------------------------
	$dir_list[] = $tmp_item;
}

//==================================================================
// Data Order
//==================================================================
$data_order = array();
$data_order["name"] = "Name";
$data_order["size"] = "Size";
if ($acc_lvl > 1) { $data_order["delete"] = "."; }

//==================================================================
// Display Files
//==================================================================
$table = new rs_list($data_order, $dir_list);
$table->empty_message("--");
//$table->display_headers(false);
$table->identify("", "dir_list table table-striped");
$table->set_col_attr('size', 'class', 'hidden-phone', false, true);
//$table->set_col_attr('size', 'class', 'rs-col-15');
//$table->set_col_attr('delete', 'class', '');
$table->render();

?>
