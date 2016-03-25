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
// Create Form
//==================================================================
$form = new form_too($mod_base_url2);
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->label($form_label);
$form->attr('.', 'form-horizontal wide-labels');

$form->add_hidden("action", $next_action[$action]);
$form->add_hidden("admin", $admin);

//==================================================================
// User ID
//==================================================================
if ($action == "add") {
	$tmp_elem = new textbox("curr_userid", $curr_userid);
}
else {
    $form->add_hidden("curr_userid", $curr_userid);
    $tmp_elem = $curr_userid;
}
$form->add_element(
	POP_TB::simple_control_group("User ID", $tmp_elem)
);

//==================================================================
// Password
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Password", new secret("password", ""))
);

//==================================================================
// First Name
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("First Name", new textbox("first_name", $first_name))
);

//==================================================================
// Last Name
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Last Name", new textbox("last_name", $last_name))
);

//==================================================================
// Account Disabled?
//==================================================================
if ($curr_userid != $_SESSION["userid"] && $admin != 1) {
    if (!isset($disabled)) { $disabled = 0; }
	$form->add_element(
		POP_TB::simple_control_group('Account Disabled', new checkbox("disabled", 1, $disabled))
	);
}

//==================================================================
// Save Button
//==================================================================
$form->add_element(POP_TB::save_button());

//==================================================================
// Render Form
//==================================================================
$form->render();

