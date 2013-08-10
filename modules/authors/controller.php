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

//--------------------------------------------------------
// Include Local Variables
//--------------------------------------------------------
include('local.var.php');

//--------------------------------------------------------
// Load Object Plugin
//--------------------------------------------------------
load_plugin('site_blog_author');

//--------------------------------------------------------
// Flow Control
//--------------------------------------------------------
switch ($this->action) {
	case "add":
	case "edit":
	case "confirm_delete":
		if ($acc_lvl < 2 && ($this->action == "add" || $this->action == "confirm_delete")) {
			add_warn_message($access_deny_msg);
    		include("main.php");
		}
		else {
			$pull_from_db = true;
    		include("form_controller.php");
    	}
    	break;
    
	case "insert":
	case "update":
	case "delete":
		if ($acc_lvl < 2 && ($this->action == "insert" || $this->action == "delete")) {
			add_warn_message($access_deny_msg);
    		include("main.php");
		}
		else {
    		include("db_action.php");
    	}
    	break;

	default:
		include("main.php");
		break;
}

?>
