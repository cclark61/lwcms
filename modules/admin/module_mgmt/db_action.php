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
if ($action == "delete") {

	$strsql = "select * from app_modules where id = ?";
	$module = qdb_first_row('', $strsql, array('i', $id));

	if (!$module) {
		add_warn_message('The module could not be uninstalled because it does not exist.');
		header("Location: {$mod_base_url}");
		exit;
		return false;
	}
	extract($module);
	if (in_array($phrase, $system_modules)) {
		add_warn_message('System modules cannot be uninstalled.');
		header("Location: {$mod_base_url}");
		exit;
		return false;	
	}

	$ssv_status = true;
}
else { include("ssv_main.php"); }

//==================================================================
// Successful Validation
//==================================================================
if ($do_trans && $ssv_status) {

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {

	    case "insert":

			//---------------------------------------------------
			// Install Module
			//---------------------------------------------------
	        $install_status = include('install.php');
	    	if ($install_status) {
	    		$mod_desc = html_sanitize($mod_desc);
        		add_action_message("The module <em>{$mod_desc}</em> has been successfully installed.");
        	}
        	else {
	        	add_warn_message("The module could not be installed.");
        	}
	        break;

	    case "delete":
	    	$mod_desc = html_sanitize($mod_desc);

	    	if (isset($button_1) && $button_1 == "Delete") {

				//---------------------------------------------------
				// Uninstall Module
				//---------------------------------------------------
		    	$uninstall_status = include('uninstall.php');
		    	if ($uninstall_status) {
	        		add_action_message("The module <em>{$mod_desc}</em> has been successfully uninstalled.");
	        	}
	        	else {
		        	add_warn_message("The module <em>{$mod_desc}</em> could not be uninstalled.");
	        	}
        	}
        	else {
        		add_warn_message("The module <em>{$mod_desc}</em> was not uninstalled.");
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
header("Location: {$redirect_url}");
exit;

