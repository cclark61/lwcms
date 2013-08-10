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
$form->attr('.', 'form-horizontal');

//==================================================================
// Hidden Variables
//==================================================================
$form->add_hidden("action", $next_action[$action]);
$form->add_hidden("id", $id);

//-----------------------------------------------------
// Add
//-----------------------------------------------------
if ($action == "add") {
	$form->add_hidden("site_id", $valid_site);
	$form->add_hidden("blog_id", $blog_id);
	$form->add_hidden("create_user", $_SESSION["userid"]);
}

//==================================================================
// Category
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Category", new textbox("category", $category, 60))
);

//==================================================================
// Active?
//==================================================================
if (!isset($active)) { $active = 0; }
$form->add_element(
	POP_TB::simple_control_group("Active", new checkbox("active", 1, $active))
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
