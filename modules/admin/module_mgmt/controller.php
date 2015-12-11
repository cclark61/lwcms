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
// Local Variables
//==================================================================
include('local.var.php');

//==================================================================
// Flow Control
//==================================================================
switch ($this->action) {

	case "add":
	case "confirm_delete":
		$pull_from_db = true;
		include("form_controller.php");
    	break;
    
	case "insert":
	case "delete":
    	include("db_action.php");
    	break;

	default:
		include("main.php");
		break;
}

