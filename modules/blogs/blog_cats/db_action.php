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
	$sbc = new site_blog_cat();
	$sbc->import();
	$sbc->no_save("id");
	//$sbe->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {
	    case "insert":
	    	$sbc->set_field_data('site_id', SITE_ID);
	        $change_id = $sbc->save();
	        add_action_message("The blog category has been successfully saved.");
	        break;

	    case "update":
	    	$sbc->set_field_data('site_id', SITE_ID);
	        $sbc->save($id);
	        $change_id = $id;
	        add_action_message("The blog category has been successfully saved.");
	        break;

	    case "delete":
	    	if (isset($button_1) && $button_1 == "Delete") {
	    		if (isset($used_blog_cats[$id])) {
	    			add_warn_message('This blog category cannot be deleted.');
	    		}
	    		else {
	        		$sbc->delete($id);
	        		add_action_message("The blog category has been successfully deleted.");
				}
        	}
        	else {
        		add_warn_message("The blog category was not deleted.");
        	}
        	break;
	}
}
//==================================================================
// Failed Validation
//==================================================================
else if ($do_trans && !$ssv_status) {
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
header("Location: {$redirect_url}");
exit;

?>
