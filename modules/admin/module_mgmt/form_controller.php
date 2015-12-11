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
	$obj = new app_module();
	$load_status = $obj->load($id);
	if (!$load_status && $action != 'add') {
		add_warn_message('Invalid Module.');
		header("Location: {$mod_base_url}");
		exit;
		return false;	
	}
	extract($obj->export());

	if (in_array($phrase, $system_modules)) {
		add_warn_message('System modules cannot be uninstalled.');
		header("Location: {$mod_base_url}");
		exit;
		return false;	
	}
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
    		$form_label = "Install or Upgrade a Module";
    		include("frm_install.php");
    		break;

		case "confirm_delete":
			$mod_desc = html_sanitize($mod_desc);
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => "Are sure you want to uninstall the Module <em>{$mod_desc}</em>?",
				'hidden_vars' => array(
					'id' => $id,
					'action' => $next_action[$action]
				),
				'form_label' => "Uninstall a Module"
			));
			break;
    }
}
else {
	header("Location: {$mod_base_url}");
	exit;
}

