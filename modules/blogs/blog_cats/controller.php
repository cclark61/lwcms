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

include('local.var.php');

//====================================================================
// Load Object Plugin
//====================================================================
load_plugin("site_blog_cat");

//====================================================================
// Flow Control
//====================================================================
if ($valid_blog && $site_id) {
	switch ($action) {
    	case "add":
    	case "edit":
    	case "confirm_delete":
    		$pull_from_db = true;
        	include("form_controller.php");
        	break;
        
    	case "insert":
    	case "update":
    	case "delete":
        	include("db_action.php");
        	break;

		default:
			include("main.php");
			break;
	}
}
else {
	$this->action = "invalid_blog";
	header("Location: {$page_url}");
	exit;
}

?>
