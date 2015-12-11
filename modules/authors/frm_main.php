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

//================================================
// Create Form
//================================================
$form = new form_too($mod_base_url2);
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->label($form_label);
$form->attr('.', 'form-horizontal');

//================================================
// Hidden Variable
//================================================
$form->add_hidden('action', $next_action[$action]);
$form->add_hidden('id', $id);

// Add
if ($action == "add") {
	$form->add_hidden('site_id', $site_id);
	$form->add_hidden('create_user', $_SESSION["userid"]);
}

//================================================
// Author Name
//================================================
$form->add_element(
	POP_TB::simple_control_group("Author Name", new textbox("author_name", $author_name))
);

//================================================
// Blog
//================================================
$strsql = "select * from site_blogs where site_id = $site_id order by blog_title";
$sst_blog = new sst("blog_id", '', $strsql, "id", "blog_title");
$sst_blog->add_blank(0, 'All');
$sst_blog->selected_value($blog_id);

$form->add_element(
	POP_TB::simple_control_group("Blog", $sst_blog)
);

//==================================================================
// Save Button
//==================================================================
$form->add_element(POP_TB::save_button());

//================================================
// Render Form
//================================================
$form->render();

