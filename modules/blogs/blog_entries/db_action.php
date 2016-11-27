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
	$sbe = new site_blog_entry();
	$sbe->import();
	$sbe->no_save("id");
	//$sbe->print_only();

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
	    	$sbe->set_field_data('site_id', SITE_ID);
	    	$sbe->set_use_bind_param("post_date", false);
	    	$sbe->set_field_quotes("post_date", "disable");
	    	$sbe->set_field_data("post_date", "NOW()");
	        $change_id = $sbe->save();

	        //-----------------------------------------------
	        // Save Content Version
	        //-----------------------------------------------
	        $version_num = false;
	        if ($change_id) {
		        $version_num = save_content_version('blog', $change_id, $_POST['entry_content'], $_SESSION['userid']);
	        }

	        //-----------------------------------------------
	        // Update Draft Version
	        //-----------------------------------------------
	        if ($change_id && $version_num) {
		        $strsql = 'update site_blog_entries set version_dev = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));
		    }

	        //-----------------------------------------------
	        // Action Message
	        // Update Published Version
	        //-----------------------------------------------
		    if (!empty($button_1) && $version_num) {
		        $strsql = 'update site_blog_entries set version_live = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));		    	
			    add_action_message("The blog entry has been successfully saved and published.");
		    }
		    else {
			    add_action_message("The blog entry has been successfully saved.");
		    }
	        break;

        //==========================================================
        //==========================================================
        // Update
        //==========================================================
        //==========================================================
	    case "update":
	    	$sbe->set_field_data('site_id', SITE_ID);
	    	$pd_date = transform_date($pd_date, "m/d/y", "sql");
	    	if ($ampm == "pm" && $pd_hour != 12) {
	    		$pd_hour += 12;
	    	}
	    	else if ($pd_hour == 12 && $ampm == "am") { $pd_hour = "00"; }
	    	$sbe->set_field_data("post_date", "{$pd_date} {$pd_hour}:{$pd_min}:00");
	        $sbe->save($id);
	        $change_id = $id;

	        //-----------------------------------------------
	        // Save Content Version
	        //-----------------------------------------------
	        $version_num = false;
	        if ($change_id) {
		        $version_num = save_content_version('blog', $change_id, $_POST['entry_content'], $_SESSION['userid']);
	        }

	        //-----------------------------------------------
	        // Update Draft Version
	        //-----------------------------------------------
	        if ($change_id && $version_num) {
		        $strsql = 'update site_blog_entries set version_dev = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));
		    }

	        //-----------------------------------------------
	        // Action Message
	        // Update Published Version
	        //-----------------------------------------------
		    if (!empty($button_1) && $version_num) {
		        $strsql = 'update site_blog_entries set version_live = ? where id = ?';
		        qdb_exec('', $strsql, array('ii', $version_num, $change_id));		    	
			    add_action_message("The blog entry has been successfully saved and published.");
		    }
		    else {
			    add_action_message("The blog entry has been successfully saved.");
		    }
	        break;

        //==========================================================
        //==========================================================
        // Delete
        //==========================================================
        //==========================================================
	    case "delete":
	    	if (isset($button_1) && $button_1 == "Delete") {
        		$sbe->delete($id);
	        	$delsql = "delete from content_version where content_type = 'blog' and entry_id = ?";
	        	qdb_exec('', $delsql, array('i', $id));
        		add_action_message("The blog entry has been successfully deleted.");
        	}
        	else {
        		add_warn_message("The blog entry was not deleted.");
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
redirect($redirect_url);

