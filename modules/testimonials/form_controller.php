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
	$obj = new $mod_dio_obj();
	if ($action == "add") { $obj->no_load("site_id"); }
	$load_status = $obj->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Testimonial');
		include('main.php');
		return false;	
	}
	extract($obj->export());
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
    		$form_label = "Add a Testimonial";
    		include("frm_main.php");
    		break;

		case "edit":
			$form_label = "Edit an Testimonial";
			include("frm_main.php");
			break;
			
		case "confirm_delete":
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to delete the Testimonial for <em>{$person_name}</em>?",
				'hidden_vars' => array(
					'id' => $id,
					'action' => $next_action[$action]
				),
				'form_label' => "Delete a Testimonial"
			));
			break;
    }
}
else {
    include("main.php");
}

