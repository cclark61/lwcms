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

$ssv = new server_side_validation();

//==================================================================
// Insert
//==================================================================
if ($this->action == "insert") {
	$ssv->add_check("file_name", "is_not_empty", "You must enter a file name.");
}

//==================================================================
// Insert
//==================================================================
if ($this->action == "insert") {
	$ssv->add_check("file_content", "is_not_empty", "You must enter file content.");
}

//==================================================================
// Update
//==================================================================
if ($this->action == "update") {

	//----------------------------------------------
	// Rename File
	//----------------------------------------------
	if ($this->action == 'update' && !empty($rename_file)) {
		$ssv->add_check("new_file_name", "is_not_empty", "You must enter a new file name.");
	}
	else {
		$ssv_status = true;
		return true;
	}
}

//==================================================================
// Add Directory
//==================================================================
if ($this->action == "insert_dir") {
	$ssv->add_check("folder_name", "is_not_empty", "You must enter a folder name.");
}

//==================================================================
// Upload File
//==================================================================
if ($this->action == "save_upload") {

	if (!isset($_FILES["datafile"]) || !isset($_FILES["datafile"]["name"]) || (isset($_FILES["datafile"]["name"][0]) && trim($_FILES["datafile"]["name"][0]) == '')) {
		$ssv->add_check("0==1", "custom", "You must select at least one file to upload.");
	}
	else {
		$ssv_status = true;
		return true;
	}
}

$ssv_status = $ssv->validate();

?>