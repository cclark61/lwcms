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
	$sb = new site_blog();
	$sb->import();
	$sb->no_save("id");
	//$sb->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($this->action) {
	    case "insert":
	    	$sb->set_field_data('site_id', SITE_ID);
	    	$sb->set_field_data('create_user', $_SESSION['userid']);
	        $change_id = $sb->save();
	        add_action_message("The blog has been successfully saved.");
	        break;

	    case "update":
	    	$sb->set_field_data('site_id', SITE_ID);
	        $sb->save($id);
	        $change_id = $id;
	        add_action_message("The blog has been successfully saved.");
	        break;

	    case "delete":
	    	if (isset($button_1) && $button_1 == "Delete") {
        		$sb->delete($id);
        		qdb_exec('', "delete from site_blog_entries where blog_id = ?", array('i', $id));
        		add_action_message("The blog has been successfully deleted.");
        	}
        	else {
        		add_warn_message("The blog was not deleted.");
        	}
        	break;
	}
}
//==================================================================
// Failed Validation
//==================================================================
else if ($do_trans && !$ssv_status) {
	$action = ($this->action == "insert") ? ("add") : ("edit");
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
header("Location: {$redirect_url}");
exit;

