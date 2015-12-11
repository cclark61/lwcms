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
// Check for display file path
//===============================================================
if (!isset($disp_file_path)) {
	add_error_message("An error has occurred. Please try again.");
	redirect($mod_base_url);
}

//===============================================================
// Check for form key
//===============================================================
$do_trans = check_and_clear_form_key($this, "form_key", $form_key);

//===============================================================
// Server Side Validation
//===============================================================
if ($action == "delete" || $action == "delete2") {
	$ssv_status = true;
}
else {
	include("ssv_main.php");
}

//==================================================================
// Successful Validation
//==================================================================
if ($do_trans && $ssv_status) {

	$file_path = str_replace("/{$base_display}", "{$base_dir}", $disp_file_path);
	$allowed = "/[^a-z0-9\\040\\.\\-\\_\\\\]/i";

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($this->action) {

		//--------------------------------------------------
		// Add File
		//--------------------------------------------------
	    case "insert":
	    	preg_replace($allowed,"", $file_name);
	    	$full_file = $file_path . "/" . $file_name;
	        if (is_dir($file_path) && is_writeable($file_path)) {
				$file_save_status = file_put_contents($full_file, $file_content);

				if ($file_save_status !== false) {
		        	add_action_message("The file <em>{$file_name}</em> has been successfully created.");
		        }
		        else {
			        add_warn_message("The file <em>{$file_name}</em> could not not be created due to an error.");
		        }
	        }
	        else {
	        	add_warn_message("The file <em>{$file_name}</em> could not not be saved.");
	        }
	        break;

		//--------------------------------------------------
		// Add Folder
		//--------------------------------------------------
		case "insert_dir":
	    	preg_replace($allowed, "", $folder_name);
	    	$full_folder = $file_path . "/" . $folder_name;
	        if (is_dir($file_path) && is_writeable($file_path)) {
				$status = mkdir($full_folder);
				if (!$status) {
					add_warn_message("The folder <em>{$folder_name}</em> could not not be created.");
				}
				else {
	        		add_action_message("The folder <em>{$folder_name}</em> has been successfully created.");
				}
	        }
	        else {
	        	add_warn_message("The folder <em>{$folder_name}</em> could not not be created.");
	        }
	        break;

		//--------------------------------------------------
		// Upload File
		//--------------------------------------------------
		case "save_upload":
	        if (is_dir($file_path) && is_writeable($file_path)) {
   		    	foreach ($_FILES['datafile']['name'] as $key => $val) {
   		    		preg_replace($allowed,"", $val);
   		    		$full_file = $file_path . "/" . $val;
   		    		$tmp_file = $_FILES['datafile']["tmp_name"][$key];
					$status = copy($tmp_file, $full_file);
					if (!$status) {
						add_warn_message("The file <em>{$val}</em> could not not be uploaded. [1]");
					}
					else {
						add_action_message("The file <em>{$val}</em> has been successfully uploaded.");
					}
				}
	        }
	        else {
	        	add_warn_message("The file(s) could not not be uploaded. [2]");
	        }
	        break;

		//--------------------------------------------------
		// Update File
		//--------------------------------------------------
	    case "update":
	    	if (is_writeable($file_path)) {

				//------------------------------------------
				// Write File Contents
				//------------------------------------------
				$file_save_status = file_put_contents($file_path, $file_content);

				//------------------------------------------
				// Rename File
				//------------------------------------------
				$rename_status = true;
				if (!empty($rename_file)) {
					preg_replace($allowed,"", $new_file_name);
					$rename_status = rename($file_path, dirname($file_path) . "/{$new_file_name}");
					if ($rename_status) {
						$file_name = $new_file_name;
					}
				}

				if ($file_save_status !== false && $rename_status) {
		        	add_action_message("The file <em>{$file_name}</em> has been successfully saved.");
		        }
		        else {
			        add_warn_message("The file <em>{$file_name}</em> could not not be saved due to an error.");
		        }
	        }
	        else {
	        	add_warn_message("The file <em>{$file_name}</em> could not not be saved because the file is read-only.");
	        }
	        break;

		//--------------------------------------------------
		// Delete File
		//--------------------------------------------------
	    case "delete":
	    	if (isset($button_1) && $button_1 = "Delete") {
	    		if (is_writeable($file_path)) {
        			$status = unlink($file_path);
        		}
        		else { $status = false; }

        		if (!$status) {
					add_warn_message("The file <em>{$file_name}</em> could not not be deleted.");
				}
				else {
	        		add_action_message("The file <em>{$file_name}</em> has been successfully deleted.");
				}
        	}
        	else { add_warn_message("The file was not deleted."); }
        	break;

		//--------------------------------------------------
		// Delete Folder
		//--------------------------------------------------
		case "delete2":
	    	if (isset($button_1) && $button_1 = "Delete") {
	    		if (is_dir($file_path) && is_writeable($file_path)) {
        			$status = rmdir($file_path);
        		}
        		else { $status = false; }

        		if (!$status) {
					add_warn_message("The folder <em>{$folder_name}</em> could not not be deleted.");
				}
				else {
	        		add_action_message("The folder <em>{$folder_name}</em> has been successfully deleted.");
				}
        	}
        	else { add_warn_message("The folder was not deleted."); }
        	break;
	}

}
//==================================================================
// Failed Validation
//==================================================================
else if (!$ssv_status) {
	switch ($action) {
		case "insert":
			$action = "add";
			break;

		case "insert_dir":
			$action = "add_dir";
			break;

		case "save_upload":
			$action = "upload_file";
			break;

		case "update":
			$action = "edit";
			break;
	}
	
	$this->action = $action;
	$ssv->display_fail_messages();
	$pull_from_db = false;
	include("form_controller.php");
	return false;
}

//==================================================================
// Everything else, Redirect
//==================================================================
$redirect_url = $mod_base_url;
if (!empty($disp_curr_dir)) {
	$redirect_url = "{$redirect_url}/{$disp_curr_dir}";
}
redirect($redirect_url);

