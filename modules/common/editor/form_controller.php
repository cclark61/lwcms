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

//===============================================================
// Set Action / Next action
//===============================================================
$next_action["add_dir"] = "insert_dir";
$next_action["upload_file"] = "save_upload";
$next_action["confirm_delete2"] = "delete2";

//===============================================================
// File Path
//===============================================================
$file_path = $curr_dir;
$disp_file_path = "/{$base_display}{$disp_curr_dir}";

if ($this->action == "edit" || $this->action == "confirm_delete" || $this->action == "confirm_delete2") {
	if (isset($file)) {
		$file = base64_decode($file);
		$file_path .= '/' . $file;
		$disp_file_path .= '/' . $file;
		$file_name = $file;
	}
	else if (isset($folder)) {
		$folder = base64_decode($folder);
		$disp_file_path .= '/' . $folder;
		$folder_name = $folder;
	}
}

//===============================================================
// Validate Action
//===============================================================
$proceed = false;
if ($this->action == "add" || $this->action == "add_dir" || $this->action == "upload_file") {
	$proceed = true;
}
else if (($this->action == "edit" || $this->action =="confirm_delete") && isset($file_path) && file_exists($file_path) && !is_dir($file_path) && is_writeable($file_path)) {
	$proceed = true;
}
else if ($this->action =="confirm_delete2" && isset($file_path) && file_exists($file_path) && is_writeable($file_path)) {
	$proceed = true;
}

//===============================================================
// Proceed?
//===============================================================
if ($proceed) {

	//---------------------------------------------
	// Back Link
	//---------------------------------------------
	$back_link = $mod_base_url;

	//---------------------------------------------
	// Flow Control
	//---------------------------------------------
    switch ($this->action) {

	    //--------------------------------------------------
	    // Add a File
	    //--------------------------------------------------
    	case "add":
       		$form_label = "Add a File";
   			include("frm_main.php");
    		break;

	    //--------------------------------------------------
	    // Add a Folder
	    //--------------------------------------------------
		case "add_dir":
       		$form_label = "Add a Folder";
   			include("frm_main.php");
    		break;

	    //--------------------------------------------------
	    // Upload a File
	    //--------------------------------------------------
		case "upload_file":
       		$form_label = "Upload a File";
   			include("frm_main.php");
    		break;

	    //--------------------------------------------------
	    // Edit a File
	    //--------------------------------------------------
		case "edit":
			$file_parts = explode(".", $file);
			$fp_size = count($file_parts);
			$ext = $file_parts[$fp_size - 1];
			if ($fp_size > 1) {
				if ($ext == 'html' || $ext == 'xhtml' || $ext == 'htm') {
					$load_tinymce = true;
					$strip_cdata = true;
				}
				else { $codemirror_mode = $ext; }
			}
			$form_label = "Edit a File";
			include("frm_main.php");
			break;

	    //--------------------------------------------------
	    // Delete a File
	    //--------------------------------------------------
		case "confirm_delete":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to delete the file <em>{$file}</em>?",
				'hidden_vars' => array(
					'disp_file_path' => $disp_file_path,
					'action' => $next_action[$action],
					'file_name' => $file_name
				),
				'form_label' => "Delete a File"
			));
			break;

	    //--------------------------------------------------
	    // Delete a Folder
	    //--------------------------------------------------
		case "confirm_delete2":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to delete the folder <em>{$folder}</em>?",
				'hidden_vars' => array(
					'disp_file_path' => $disp_file_path,
					'action' => $next_action[$action],
					'folder_name' => $folder_name
				),
				'form_label' => "Delete a Folder"
			));
			break;
    }
}
else {
    include("main.php");
}

