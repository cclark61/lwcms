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

//=================================================================
// Pull User List
//=================================================================
$users_list = get_non_admin_user_list();
foreach ($users_list as &$item) { $item = html_escape($item); }
if (count($users_list) > 0) {

	//=================================================================
	// Create Form
	//=================================================================
	$form = new form_too($mod_base_url2);
	$form->label("Select a User");
	$form->attr('.', 'form-horizontal');
	$form->add_hidden("action", "edit");
	
	//=================================================================
	// User Dropdown
	//=================================================================
	$user_select = new ssa("curr_userid", $users_list);
	$form->add_element(
		POP_TB::simple_control_group(false, $user_select)
	);
	
	//=================================================================
	// Save Button
	//=================================================================
	$form->add_element(POP_TB::save_button('Next'));
	
	//=================================================================
	// Render Form
	//=================================================================
	$form->render();
}
else {
	add_gen_message('There are currently no users to configure access.');
}

?>
