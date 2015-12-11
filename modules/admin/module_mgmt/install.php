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
// Validate Module ZIP Package
//==================================================================
$new_mod_info = check_module_package();
if (!$new_mod_info) { return false; }

//==================================================================
// Check if module is already installed
//==================================================================
$strsql = "select * from app_modules where phrase = ?";
$module = qdb_first_row('', $strsql, array('s', $new_mod_info['phrase']));

//==================================================================
//==================================================================
// New Install
//==================================================================
//==================================================================
if (!$module) {
	$num_errors = 0;
	$phrase = $new_mod_info['phrase'];
	$mod_desc = $new_mod_info['mod_desc'];
	$mod_path = "{$_SESSION['file_path']}/modules/{$phrase}";

	//********************************************************
	// Is this a System Module?
	//********************************************************
	if (in_array($phrase, $system_modules)) {
		add_warn_message('This module cannot be installed because it conflicts with a system module.');
		return false;	
	}

	//********************************************************
	// Install Module Files
	//********************************************************
	$zip = new ZipArchive();
	if ($zip->open($_FILES["datafile"]["tmp_name"]) === true) {
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$file_name = $zip->getNameIndex($i);
			if (substr($file_name, 0, strlen($phrase)) == $phrase) {
				$extract_dest = "{$_SESSION['file_path']}/modules/";
				if (is_dir($extract_dest) && is_writable($extract_dest)) {
			        $zip->extractTo($extract_dest, $file_name);
			    }
			    else {
					add_warn_message("Unable to install module files because the main modules directory is not writeable.");
					return false;				    
			    }
		    }
	    }
		$zip->close();
	}
	else {
		add_warn_message("Could not open module package.");
		return false;
	}

	//********************************************************
	// Run install script
	//********************************************************
	if (file_exists("{$mod_path}/module_info/install.php")) {
		include("{$mod_path}/module_info/install.php");
	}

	//********************************************************
	// Errors? Return False.
	//********************************************************
	if ($num_errors) {
		add_warn_message("{$num_errors} errors were encountered while installing the module <em>{$mod_desc}</em>.");
		return false;
	}
	else {
		//********************************************************
		// Insert Module Entry in database
		//********************************************************
		$am = new app_module();
		$am->import($new_mod_info);
		$am->save();
	}
}
//==================================================================
//==================================================================
// Upgrade
//==================================================================
//==================================================================
else {
	extract($module);
	$num_errors = 0;
	$mod_path = "{$_SESSION['file_path']}/modules/{$phrase}";

	//********************************************************
	// Is the new version older than the current version
	//********************************************************
	if ((float)$new_mod_info['version'] < (float)$version) {
		add_warn_message('Cannot upgrade this module because the package you have given is older than the currently installed version.');
		return false;			
	}

	//********************************************************
	// Is this a System Module?
	//********************************************************
	if (in_array($phrase, $system_modules)) {
		add_warn_message('This module cannot be upgraded because it conflicts with a system module.');
		return false;	
	}

	//********************************************************
	// Install Module Files
	//********************************************************
	$zip = new ZipArchive();
	if ($zip->open($_FILES["datafile"]["tmp_name"]) === true) {
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$file_name = $zip->getNameIndex($i);
			if (substr($file_name, 0, strlen($phrase)) == $phrase) {
		        $zip->extractTo("{$_SESSION['file_path']}/modules/", $file_name);
		    }
	    }
		$zip->close();
	}
	else {
		add_warn_message("Could not open module package.");
		return false;
	}

	//********************************************************
	// Run install script
	//********************************************************
	if (file_exists("{$mod_path}/module_info/upgrade.php")) {
		include("{$mod_path}/module_info/upgrade.php");
	}

	//********************************************************
	// Errors? Return False.
	//********************************************************
	if ($num_errors) {
		add_warn_message("{$num_errors} errors were encountered while upgrading the module <em>{$mod_desc}</em>.");
		return false;
	}
	else {
		//********************************************************
		// Update Module Entry in database
		//********************************************************
		$am = new app_module();
		$am->import($new_mod_info);
		$am->save($id);
	}

}

return true;

