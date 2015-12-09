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

//--------------------------------------------
// Add
//--------------------------------------------
if ($action == "add") {
	$form->add_hidden("site_id", $valid_site);
	$form->add_hidden("blog_id", $blog_id);
	$form->add_hidden("create_user", $_SESSION["userid"]);
}

//==================================================================
// Title
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Title", new textbox("entry_title", $entry_title, 60))
);

//==================================================================
// Author
//==================================================================
$strsql = "
	select * from site_blog_authors 
	where 
		site_id = ? 
		and (blog_id = ? or blog_id = 0)
	order by author_name
";
$authors = qdb_exec('', $strsql, array('ii', $site_id, $blog_id), 'id:author_name');
$ssa_author = new ssa("entry_author", $authors);
$ssa_author->add_blank();
$ssa_author->selected_value($entry_author);

$form->add_element(
	POP_TB::simple_control_group("Author", $ssa_author)
);

//==================================================================
// Category
//==================================================================
$strsql = "
	select * from site_blog_cats 
	where 
		site_id = ? 
		and blog_id = ?
		and (active = 1 || id = ?) 
	order by category
";
$cats = qdb_exec('', $strsql, array('iii', $site_id, $blog_id, $cat_id), 'id:category');
$ssa_cats = new ssa("cat_id", $cats);
$ssa_cats->add_blank();
$ssa_cats->selected_value($cat_id);

$form->add_element(
	POP_TB::simple_control_group("Category", $ssa_cats)
);

//==================================================================
// Post Date
//==================================================================
if ($action == "edit") {

	if (!isset($ssv_status)) {
		list($pd_date, $pd_hour, $pd_min, $pd_sec, $ampm) = parse_timestamp($post_date);
	}

	//-----------------------------------------------
	// Hours
	//-----------------------------------------------
	$arr_hour = array();
	for ($x = 1; $x < 13; $x++) { $arr_hour[$x] = $x; }
	$ssa_hour = new ssa("pd_hour", $arr_hour);
	$ssa_hour->selected_value($pd_hour);
	
	//-----------------------------------------------
	// Minutes
	//-----------------------------------------------
	$arr_min = array();
	for ($x = 0; $x < 60; $x++) {
		$tmp_x = ($x < 10) ? ("0" . $x) : ($x);
		$arr_min[$x] = $tmp_x;
	}
	$ssa_min = new ssa("pd_min", $arr_min);
	$ssa_min->selected_value($pd_min);
	
	//-----------------------------------------------
	// AM / PM
	//-----------------------------------------------
	$arr_ampm = array("am" => "AM", "pm" => "PM");
	$ssa_ampm = new ssa("ampm", $arr_ampm);
	$ssa_ampm->selected_value($ampm);

	//-----------------------------------------------
	// Date
	//-----------------------------------------------
	$txt_pd_date = new textbox("pd_date", $pd_date, 10);
	$txt_pd_date->attr('.', 'datepicker');

	//-----------------------------------------------
	// Add form elements
	//-----------------------------------------------
	$form->add_element(
		POP_TB::simple_control_group(
			"Post Date", 
			array($txt_pd_date, $ssa_hour, $ssa_min, $ssa_ampm), 
			false, 
			array('class' => 'select-width-auto')
		)
	);

}

//==================================================================
// Custom Data
//==================================================================
//$form->add_element(
//	POP_TB::simple_control_group("Custom Data", new textarea("entry_keywords", $entry_keywords, 70, 5))
//);

//==================================================================
// Active?
//==================================================================
if (!isset($active)) { $active = 0; }
$form->add_element(
	POP_TB::simple_control_group("Active", new checkbox("active", 1, $active))
);

//==================================================================
// Start Content Fieldset
//==================================================================
$form->start_fieldset('Content');

//==================================================================
// Content
//==================================================================
$ta_content = new textarea("entry_content", strip_cdata_tags($entry_content), 70, 30);
$ta_content->attr('.', 'mceEditor');
$form->add_element(
	POP_TB::simple_control_group(false, $ta_content)
);

//==================================================================
// End Content Fieldset
//==================================================================
$form->end_fieldset();

//==================================================================
// Save Buttons
//==================================================================
$form->add_element(
	POP_TB::simple_control_group(false, array(
		button('Save', array('name' => 'button_0', 'value' => 'Save', 'type' => 'submit', 'class' => 'btn btn-primary')),
		button('Save and Publish', array('name' => 'button_1', 'value' => 'Save and Publish', 'type' => 'submit', 'class' => 'btn btn-success'))
	))
);

//==================================================================
// Render Form
//==================================================================
if ($cats && $authors) { $form->render(); }
else {
	if (!$cats) {
		add_gen_message('You must add at least one category before you create a blog entry.');
	}
	if (!$authors) {
		add_gen_message('You must add at least one author before you create a blog entry.');
	}	
}

?>
