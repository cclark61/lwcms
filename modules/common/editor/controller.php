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

$mod_home_url = $mod_base_url;
define('BASE_DIR', $base_dir);

//========================================================================
// Is Document Root Valid?
//========================================================================
if (!is_dir($base_dir)) {
	add_warn_message("The {$root_folder_name} for this site is not set or is invalid!");
	return false;
}

//========================================================================
// Get Current Working Directory
//========================================================================
if (!include('get_curr_dir.php')) {
	add_warn_message("The currently selected directory is invalid!");
	return false;
}

//========================================================================
// Flow Control
//========================================================================
switch ($this->action) {

	case "add":
	case "add_dir":
	case "upload_file":
	case "edit":
	case "confirm_delete":
	case "confirm_delete2":
		if ($acc_lvl < 2 && ($this->action != "edit")) {
			add_warn_message($access_deny_msg);
			include("main.php");
		}
		else {
			$pull_from_db = true;
			include("form_controller.php");
		}
		break;
	
	case "insert":
	case "insert_dir":
	case "save_upload":
	case "update":
	case "delete":
	case "delete2":
		if ($acc_lvl < 2 && ($this->action != "update")) {
			add_warn_message($access_deny_msg);
			include("main.php");
		}
		else {
			include("db_action.php");
		}
		break;

	default:
		include('main.php');
		break;
}

