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
// Pull List of users and admin rights
//=================================================================
$strsql = "select userid, first_name, last_name, admin from users where userid != 'admin' order by userid";

//=================================================================
// Update
//=================================================================
$user_access = qdb_list('', $strsql, "userid:admin");  // Ok

if ($this->action == "update" && isset($update) && $update == "1") {
	foreach ($user_access as $user => $user_isadmin) {
		$$user = (isset($$user) && $$user == "1") ? (1) : (0);
		if ($user_isadmin == "1" && $$user == 0) {
			$strsql2 = "update users set admin = 0 where userid = ?";
			qdb_exec('', $strsql2, array('s', $user));
		}
		else if ($user_isadmin == "0" && $$user == 1) {
			$strsql2 = "update users set admin = 1 where userid = ?";
			qdb_exec('', $strsql2, array('s', $user));
		}
	}
	add_action_message("System Administrators have been updated.");
}

$user_list = qdb_list('', $strsql); // Ok

if ($user_list) {
	//=================================================================
	// Create Form
	//=================================================================
	$form = new form_too($mod_base_url2);
	$form->label("Select Administrators");
	
	$form->add_hidden("action", "update");
	$form->add_hidden("update", 1);
	
	$str_users = '';
	foreach ($user_list as $user) {
		$user_name = html_escape($user["first_name"] . " " . $user["last_name"]);
		$chk_user = new checkbox($user["userid"], 1, $user["admin"]);
		$str_users .= POP_TB::checkbox_label("{$chk_user} {$user_name}");
	}
	
	$form->add_element(
		POP_TB::simple_control_group(false, $str_users)
	);

	$form->add_element(POP_TB::save_button('Update'));

	//=================================================================
	// Render Form
	//=================================================================
	$form->render();
}
else {
	add_warn_message('No users available at this time.');	
}

?>
