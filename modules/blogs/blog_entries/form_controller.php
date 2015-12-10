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
// Set ID if blank
//==================================================================
if (!isset($id)) { $id = ""; }

//==================================================================
// Create object
//==================================================================
if ($pull_from_db) {
	$sbe = new site_blog_entry();
	if ($action == "add") {
		$sbe->no_load("site_id");
		$sbe->no_load("blog_id");
	}
	$load_status = $sbe->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Blog Entry');
		include('main.php');
		return false;	
	}
	extract($sbe->export());
}

//==================================================================
// Validate Action
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
    		$form_label = "Add a blog entry";
    		include("frm_main.php");
    		break;

		case "edit":
			$form_label = "Edit a blog entry";
			include("frm_main.php");
			break;

		case "view_version":
			$this->page_type = 'page_text';
			$content_type = 'blog';
			include("{$mod_common_dir}/content_versions/view_version.php");
			break;

		case "revisions":
			$content_type = 'blog';
			include("{$mod_common_dir}/content_versions/revisions.php");
			break;
			
		case "confirm_delete":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to delete the blog entry <em>{$entry_title}</em>?",
				'hidden_vars' => array(
					'id' => $id,
					'action' => $next_action[$action]
				),
				'form_label' => "Delete a Blog Entry"
			));
			break;
    }
}
else {
    include("main.php");
}

