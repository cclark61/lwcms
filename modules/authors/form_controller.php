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
	$sba = new site_blog_author();
	if ($action == "add") { $sba->no_load("site_id"); }
	$load_status = $sba->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Author');
		include('main.php');
		return false;	
	}
	extract($sba->export());
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
    		$form_label = "Add an author";
    		include("frm_main.php");
    		break;

		case "edit":
			$form_label = "Edit an author";
			include("frm_main.php");
			break;
			
		case "confirm_delete":
			if (isset($used_blog_authors[$id]) || isset($used_content_authors[$id])) {
				add_warn_message('This author cannot be deleted.');
				include("main.php");
			}
			else {
				POP_TB::delete_form($this, array(
					'url' => $mod_base_url2,
					'message' => "Are sure you want to delete the author <em>{$author_name}</em>?",
					'hidden_vars' => array(
						'id' => $id,
						'action' => $next_action[$action]
					),
					'form_label' => "Delete an author"
				));
			}
			break;
    }
}
else {
    include("main.php");
}

?>
