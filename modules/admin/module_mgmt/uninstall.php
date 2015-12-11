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
// Local Functions
//==================================================================
include('local.func.php');

//==================================================================
// Check if module is installed
//==================================================================
$strsql = "select * from app_modules where id = ?";
$module = qdb_first_row('', $strsql, array('i', $id));

//==================================================================
// Module Exists
//==================================================================
if ($module) {
	extract($module);
	$num_errors = 0;

	//********************************************************
	// Is this a System Module?
	//********************************************************
	if (in_array($phrase, $system_modules)) {
		add_warn_message('System modules cannot be uninstalled.');
		return false;	
	}

	//********************************************************
	// Check Uninstall Directories
	//********************************************************
	if (check_uninstall_dirs($phrase)) {
		add_warn_message("Unable to uninstall module components.");
		return false;
	}

	//********************************************************
	// Run Uninstall Script (if it exists)
	//********************************************************
	$uninstall_script = "{$this->file_path}/modules/{$phrase}/module_info/uninstall.php";
	if (file_exists($uninstall_script)) { include($uninstall_script); }

	//********************************************************
	// Uninstall Module Files
	//********************************************************
	$num_errors += rrmdir("{$this->file_path}/modules/{$phrase}");

	//********************************************************
	// Errors? Return False.
	//********************************************************
	if ($num_errors) {
		add_warn_message("{$num_errors} errors were encountered while installing the module <em>{$mod_desc}</em>.");
		return false;
	}
	else {
		//-------------------------------------------
		// Remove Module Record From Database
		//-------------------------------------------
		$strsql = "delete from app_modules where phrase = ?";
		qdb_exec('', $strsql, array('s', $phrase));		
	}

}
//==================================================================
// Module does NOT exist
//==================================================================
else {
	add_warn_message('The module could not be uninstalled because it does not exist.');
	return false;
}

return true;

