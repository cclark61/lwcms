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
if ($action == "delete" || $action == 'update_folder_opts') {
	$ssv_status = true;
}
else {
	include("ssv_main.php");

	//-------------------------------------------------
	// Post Date
	//-------------------------------------------------
	if (isset($_POST['pd_date']) && $ssv_status && $action == 'update' && $entry_type == 2) {
		$pd_date = transform_date($pd_date, "m/d/y", "sql");
		if ($pd_ampm == "pm" && $pd_hour != 12) { $pd_hour += 12; }
		else if ($pd_hour == 12 && $pd_ampm == "am") { $pd_hour = "00"; }
		$pd_stamp = "{$pd_date} {$pd_hour}:{$pd_min}:00";
	}
}

//==================================================================
// Successful Validation
//==================================================================
if ($do_trans && $ssv_status) {

	//---------------------------------------------------
	// Meta Tags
	//---------------------------------------------------
	if (!empty($metadata)) {
		foreach ($metadata as $md_key => $md_val) {
			if ($md_val == '') { unset($metadata[$md_key]); }
		}
		$_POST['metadata'] = json_encode($metadata);
	}

	//---------------------------------------------------
	// Create new object
	//---------------------------------------------------
	if (!isset($id)) { $id = ""; }
	$se = new site_entry();
	$se->import();
	$se->no_save("id");
	//$se->print_only();

	//---------------------------------------------------
	// Flow Control
	//---------------------------------------------------
	switch ($action) {

        //==========================================================
        //==========================================================
        // Insert
        //==========================================================
        //==========================================================
	    case "insert":
	    	$se->set_field_data('site_id', SITE_ID);
	    	if ($entry_type == 2) {
	    		$se->set_use_bind_param('post_date', false);
	    		$se->set_field_quotes('post_date', 'disable');
	        	$se->set_field_data("post_date", "NOW()");
	    	}
	    	else if ($entry_type == 1 && isset($FOLDER_OPTS) && is_array($FOLDER_OPTS)) {
		    	$json_folder_opts = json_encode($FOLDER_OPTS);
		    	$se->set_field_data("metadata", $json_folder_opts);
	    	}
	        $change_id = $se->save();

	        //-----------------------------------------------
	        // Save Content Version
	        //-----------------------------------------------
	        $version_num = false;
	        if ($entry_type == 2 && $change_id) {
	        	$version_num = save_content_version('dyn_cont', $change_id, $_POST['content'], $_SESSION['userid']);
	        }

	        //-----------------------------------------------
	        // Update Draft Version
	        //-----------------------------------------------
	        if ($entry_type == 2 && $version_num) {
		        $strsql = 'update site_entries set version_dev = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));
		    }

	        //-----------------------------------------------
	        // Action Message
	        // Update Published Version
	        //-----------------------------------------------
	        $entry_type_disp = ($entry_type == 1) ? ('folder') : ('entry');
		    if ($entry_type == 2 && !empty($button_1) && $version_num) {
		        $strsql = 'update site_entries set version_live = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));		    	
			    add_action_message("The {$entry_type_disp} has been successfully saved and published.");
		    }
		    else {
			    add_action_message("The {$entry_type_disp} has been successfully saved.");
		    }
	        break;

        //==========================================================
        //==========================================================
        // Update
        //==========================================================
        //==========================================================
	    case "update":
	    	$se->set_field_data('site_id', SITE_ID);
	    	if ($entry_type == 2) { $se->set_field_data("post_date", $pd_stamp); }
    		$se->set_use_bind_param('mod_date', false);
    		$se->set_field_quotes('mod_date', 'disable');
        	$se->set_field_data("mod_date", "NOW()");
			$se->no_save('index_content');
	    	if ($entry_type == 1 && isset($FOLDER_OPTS) && is_array($FOLDER_OPTS)) {
		    	$json_folder_opts = json_encode($FOLDER_OPTS);
		    	$se->set_field_data("metadata", $json_folder_opts);
	    	}
	        $se->save($id);
	        $change_id = $id;

	        //-----------------------------------------------
	        // Save Content Version
	        //-----------------------------------------------
	        $version_num = false;
	        if ($entry_type == 2 && $change_id) {
	        	$version_num = save_content_version('dyn_cont', $change_id, $_POST['content'], $_SESSION['userid']);
	        }

	        //-----------------------------------------------
	        // Update Draft Version
	        //-----------------------------------------------
	        if ($entry_type == 2 && $version_num) {
		        $strsql = 'update site_entries set version_dev = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));
		    }

	        //-----------------------------------------------
	        // Action Message
	        // Update Published Version
	        //-----------------------------------------------
	        $entry_type_disp = ($entry_type == 1) ? ('folder') : ('entry');
		    if ($entry_type == 2 && !empty($button_1) && $version_num) {
		        $strsql = 'update site_entries set version_live = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));		    	
			    add_action_message("The {$entry_type_disp} has been successfully saved and published.");
		    }
		    else {
			    add_action_message("The {$entry_type_disp} has been successfully saved.");
		    }
	        break;

        //==========================================================
        //==========================================================
        // Delete
        //==========================================================
        //==========================================================
	    case "delete":
	    	$entry_type_disp = ($entry_type == 1) ? ('folder') : ('entry');
	    	if (isset($button_1) && $button_1 == "Delete" && isset($node_path)) {
        		$se->delete($id);
        		if ($entry_type == 1) {
	        		$node_path .= ($node_path != "") ? (":$id") : ($id);
	        		$delsql = "delete from {$mod_table} where node_path like ?";
	        		qdb_exec('', $delsql, array('s', "{$node_path}%"));
	        	}
	        	else {
		        	$delsql = "delete from content_version where content_type = 'dyn_cont' and entry_id = ?";
		        	qdb_exec('', $delsql, array('i', $id));
	        	}
        		add_action_message("The {$entry_type_disp} has been successfully deleted.");
        	}
        	else {
        		add_warn_message("The {$entry_type_disp} was not deleted.");
        	}
        	break;

        //==========================================================
        //==========================================================
        // Update Folder Options
        //==========================================================
        //==========================================================
        case 'update_folder_opts':
        	SiteEntries::SaveFolderOptions($id, SITE_ID, $FOLDER_OPTS);
		    add_action_message("The folder options have been successfully saved.");
        	break;

	}
}
//==================================================================
// Failed Validation
//==================================================================
else if (!$ssv_status) {
	$action = $prev_action;
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

