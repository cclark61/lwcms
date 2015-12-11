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
	$s = new site();
	$s->import();
	$s->no_save("id");
	//$s->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {
	    case "insert":
	        $change_id = $s->save();
	        update_asms($change_id);
	        add_action_message("The site has been successfully saved.");
	        break;

	    case "update":
	        $s->save($id);
	        $change_id = $id;
	        update_asms($change_id);
	        add_action_message("The site has been successfully saved.");
	        break;

	    case "delete":
	    	if (isset($button_1) && $button_1 == "Delete") {
        		$s->delete($id);
        		$tables = qdb_list('', "show tables"); // Ok
        		$table_index = "Tables_in_" . $_SESSION[$_SESSION["lwcms_ds"]]["source"];
        		foreach ($tables as $table) {
        			$table_name = $table[$table_index];
        			$strsql = "show columns from {$table_name} where Field = 'site_id'";
        			$fields = qdb_list('', $strsql); // Ok
        			if (count($fields) > 0) {
        				qdb_exec('', "delete from {$table_name} where site_id = ?", array('i', $id));
        			}
        		}
        		add_action_message("The site has been successfully deleted.");
        	}
        	else {
        		add_warn_message("The site was not deleted.");
        	}
        	break;
	}
}
//==================================================================
// Failed Validation
//==================================================================
else if (!$ssv_status) {
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
redirect($redirect_url);
