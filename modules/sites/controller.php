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
// Local Variables / Settings
//==================================================================
include('local.var.php');

//==================================================================
// Check for Valid Site ID in URL
//==================================================================
if ($site_id && $segment_1 && is_numeric($segment_1)) {
	$action = $this->action = 'view';
	$id = $site_id;
}

//==================================================================
// Flow Control
//==================================================================
switch ($this->action) {

    case "add":
    case "edit":
    case "confirm_delete":
    	if ($admin_status > 0) {
    		$pull_from_db = true;
    		include("form_controller.php");
    	}
    	else { include("main.php"); }
        break;
        
    case "insert":
    case "update":
    case "delete":
    	if ($admin_status > 0) { include("db_action.php"); }
    	else { include("main.php"); }
        break;

	case "view":
		$pull_from_db = true;
		include("form_controller.php");
		break;

	default:
		//------------------------------------------------------------
		// Site Modules (stored in session)
		//------------------------------------------------------------
		$_SESSION["app_modules"] = AppModules::get("phrase");
		include("main.php");
		break;
}

