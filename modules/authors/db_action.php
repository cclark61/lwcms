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
// Check for form key
//==================================================================
$do_trans = check_and_clear_form_key($this, "form_key", $form_key);

//==================================================================
// Server Side Validation
//==================================================================
if ($action == "delete") { $ssv_status = true; }
else { include("ssv_main.php"); }

//==================================================================
// Successful Validation
//==================================================================
if ($do_trans && $ssv_status) {

	//---------------------------------------------------
	// Create new object
	//---------------------------------------------------
	if (!isset($id)) { $id = ""; }
	$obj = new site_blog_author();
	$obj->import();
	$obj->no_save("id");
	//$obj->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {
	    case "insert":
	    	$obj->set_field_data('site_id', SITE_ID);
	        $change_id = $obj->save();
	        add_action_message("The author has been successfully saved.");
	        break;

	    case "update":
	    	$obj->set_field_data('site_id', SITE_ID);
	        $obj->save($id);
	        $change_id = $id;
	        add_action_message("The author has been successfully saved.");
	        break;

	    case "delete":
	    	if (isset($button_1) && $button_1 == "Delete") {
	    		if (isset($used_blog_authors[$id]) || isset($used_content_authors[$id])) {
	    			add_warn_message('This author cannot be deleted.');
	    		}
	    		else {
	        		$obj->delete($id);
	        		add_action_message("The author has been successfully deleted.");
				}
        	}
        	else {
        		add_warn_message("The author was not deleted.");
        	}
        	break;
	}
}
//==================================================================
// Failed Validation
//==================================================================
else if (!$ssv_status) {
	$action = ($action == "insert") ? ("add") : ("edit");
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
if (!empty($change_id)) {
	$redirect_url = add_url_params($redirect_url, array('change_id' => $change_id));
}
redirect($redirect_url);

