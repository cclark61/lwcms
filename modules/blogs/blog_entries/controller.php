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

//====================================================================
// Flow Control
//====================================================================
if ($valid_blog && $site_id) {
	switch ($action) {

    	case "add":
    	case "confirm_delete":
    		if ($acc_lvl > 1) {
	    		$pull_from_db = true;
	        	include("form_controller.php");
	        }
			else {
				add_warn_message($access_deny_msg);
				include("main.php");
			}
        	break;

    	case "edit":
    	case 'revisions':
    	case 'view_version':
    		$pull_from_db = true;
        	include("form_controller.php");
        	break;

    	case "insert":
    	case "delete":
    		if ($acc_lvl > 1) {
	        	include("db_action.php");
	        }
			else {
				add_warn_message($access_deny_msg);
				include("main.php");
			}
        	break;

    	case "update":
        	include("db_action.php");
        	break;

		default:
			include("main.php");
			break;
	}
}
else {
	$this->action = "invalid_blog";
	redirect($page_url);
}

