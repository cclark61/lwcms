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
	if (!isset($userid)) { $userid = ""; }
	$u = new app_user();
	$u->no_save("admin");
	$u->import();
	//$u->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {
		case "insert":
			$u->set_field_data("password", get_saveable_password($password));
			$u->set_field_data("userid", $curr_userid);
			$u->save();
			add_action_message("The user was added successfully.");
			break;
				
		case "update":
			if (empty($password)) {
				$u->no_save("password");
			}
			else {
				$u->set_field_data("password", get_saveable_password($password));
			}
			$u->save($curr_userid);
			add_action_message("The user was updated successfully.");
			break;
				
		case "delete":
			if (isset($button_1) && $button_1 == "Delete") {
				$curr_user = get_user_info($curr_userid);
				if ($curr_user) {
					if (isset($curr_user["admin"]) && $curr_user["admin"] == 0 && $curr_userid != "admin") {
						$u->delete($curr_userid);
						$strsql = 'delete from site_access where userid = ?';
						qdb_exec('', $strsql, array('s', $curr_userid));
						add_action_message("The user was deleted successfully.");
					}
					else { add_warn_message("This user cannot be deleted."); }
				}
				else { add_warn_message("This user does not exist."); }
			}
        	else { add_warn_message("The user was not deleted."); }
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
header("Location: {$redirect_url}");
exit;

?>
