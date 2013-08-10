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
	$sbc = new site_blog_cat();
	if ($action == "add") {
		$sbc->no_load("site_id");
		$sbc->no_load("blog_id");
	}
	$load_status = $sbc->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Blog Category');
		include('main.php');
		return false;	
	}
	extract($sbc->export());
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
    		$form_label = "Add a blog category";
    		include("frm_main.php");
    		break;

		case "edit":
			$form_label = "Edit a blog category";
			include("frm_main.php");
			break;
			
		case "confirm_delete":
			if (isset($used_blog_cats[$id])) {
				add_warn_message('This blog category cannot be deleted.');
				include("main.php");
			}
			else {
				POP_TB::delete_form($this, array(
					'url' => $mod_base_url2,
					'message' => "Are sure you want to delete the blog category <em>{$category}</em>?",
					'hidden_vars' => array(
						'id' => $id,
						'action' => $next_action[$action]
					),
					'form_label' => "Delete a Blog Category"
				));
			}
			break;
    }
}
else {
    include("main.php");
}

?>
