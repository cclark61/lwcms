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
// New Validation
//==================================================================
$ssv = new server_side_validation();

//==================================================================
// USer ID Not Empty
//==================================================================
$ssv->add_check("curr_userid", "is_not_empty", "You must enter a userid.");

//==================================================================
// Insert Only
//==================================================================
if ($this->action == "insert") {

	//---------------------------------------------------
	// Check if User ID is taken
	//---------------------------------------------------
	$curr_user = get_user_info($curr_userid);
	if ($curr_user) { $ssv->add_check("0 == 1", "custom", "This User ID already exists, please try another User ID."); }
	
	//---------------------------------------------------
	// Check for Password
	//---------------------------------------------------
	$ssv->add_check("password", "is_not_empty", "You must enter a password.");
}

//==================================================================
// Check First and Last Name
//==================================================================
$ssv->add_check("first_name", "is_not_empty", "You must enter a first name.");
$ssv->add_check("last_name", "is_not_empty", "You must enter a last name.");

//==================================================================
// Validate
//==================================================================
$ssv_status = $ssv->validate();

