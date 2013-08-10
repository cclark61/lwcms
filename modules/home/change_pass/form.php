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
$form = new form_too(BASE_URL . 'change_pass/');
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->attr('.', 'form-horizontal');

//==================================================================
// Hidden Variables
//==================================================================
$form->add_hidden("update_pass", 1);

//==================================================================
// Current Password
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Current Password", new secret("curr_pass", ""))
);

//==================================================================
// New Password
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("New Password", new secret("new_pass1", ""))
);

//==================================================================
// New Password, Again
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Re-type Password", new secret("new_pass2", ""))
);

//==================================================================
// Save Button
//==================================================================
$form->add_element(POP_TB::save_button());

//==================================================================
// Render Form
//==================================================================
$form->render();

?>