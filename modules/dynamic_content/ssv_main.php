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

//====================================================================
// Create New Validation
//====================================================================
$ssv = new server_side_validation();

//====================================================================
// Folder Validations
//====================================================================
if ($entry_type == 1) {
	$ssv->add_check("entry_title", "is_not_empty", "You must enter a folder name.");
}

//====================================================================
// Entry Validations
//====================================================================
else if ($entry_type == 2) {
	$ssv->add_check("entry_title", "is_not_empty", "You must enter an entry title.");
	
	if ($action == 'update' & isset($_POST['pd_date'])) {
		$ssv->add_check("pd_date", "is_not_empty", "You must enter a post date.");
		if ($pd_date != "") {
			$ssv->add_check("pd_date", "is_date", "Post date must be a valid date (mm/dd/yyyy).");
		}
	}
}
//====================================================================
// Other ??
//====================================================================
else {
	$ssv->add_check("entry_title", "is_not_empty", "You must enter an entry name.");
}

//====================================================================
// VAlidate
//====================================================================
$ssv_status = $ssv->validate();

?>