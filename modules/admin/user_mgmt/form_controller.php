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
// Breadcrumbs
//==================================================================
$breadcrumbs[] = anchor($mod_base_url2, "User Management");

//==================================================================
// User ID
//==================================================================
if (!isset($curr_userid)) { $curr_userid = ""; }

//==================================================================
// Create object
//==================================================================
if ($pull_from_db) {
	$u = new app_user();
	$u->no_load('userid');
	$load_status = $u->load($curr_userid);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid User');
		include('main.php');
		return false;	
	}
	extract($u->export());
}

//==================================================================
// Check if user exists or we are ADDING
//==================================================================
if (isset($next_action[$action])) {

	//------------------------------------------
	// Back Link
	//------------------------------------------
	$back_link = $mod_base_url;

	//------------------------------------------
	// Flow Control
	//------------------------------------------
    switch ($action) {
		case "add":
			$form_label = "Add a User";
			include("frm_main.php");
			break;

		case "edit":
			$form_label = "Edit a User";
			include("frm_main.php");
			break;

		case "confirm_delete":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to delete the user <em>{$first_name} {$last_name} [{$curr_userid}]</em>?",
				'hidden_vars' => array(
					'curr_userid' => $curr_userid,
					'action' => $next_action[$action]
				),
				'form_label' => "Delete a User"
			));
			break;
    }
}
else {
    include("main.php");
}

?>
