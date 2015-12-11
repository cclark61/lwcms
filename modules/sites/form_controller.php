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
if (!isset($id)) { $id = ''; }

//==================================================================
// Create object
//==================================================================
if ($pull_from_db) {
	$s = new site();
	$load_status = $s->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Site');
		include('main.php');
		return false;	
	}
	extract($s->export());
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
			$form_label = "Add a Site";
			include("frm_main.php");
			break;

		case "edit":
			$form_label = "Edit a Site";
			include("frm_main.php");
			break;

		case "view":
			if (isset($id)) { $site_id = $id; }
			unset($back_link);
			include("view.php");
			break;

		case "confirm_delete":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are you sure want to DELETE the site <em>{$site_name}</em> and all of it's entries?",
				'hidden_vars' => array(
					'id' => $id,
					'action' => $next_action[$action]
				),
				'form_label' => "Delete a Site"
			));
			break;
    }
}
else {
    include("main.php");
}

