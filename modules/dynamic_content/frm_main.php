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
// Extract JSON Data from Meta Data Field
//==================================================================
$se_id = ($entry_type == 2 || $action == 'add_entry') ? ($parent) : ($id);
$FOLDER_OPTS = SiteEntries::GetFolderOptions($se_id);
//var_dump($FOLDER_OPTS);

//==================================================================
// WYSIWYG?
//==================================================================
if (!isset($FOLDER_OPTS['use_wysiwyg'])) { $FOLDER_OPTS['use_wysiwyg'] = 1; }
if (($action == 'add_entry' || $entry_type == 2) && $FOLDER_OPTS['use_wysiwyg']) {
	$load_tinymce = true;
}

//==================================================================
// Create Form
//==================================================================
$form = new form_too($mod_base_url2);
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->label($form_label);
$form->attr('.', 'form-horizontal wide-labels');

//==================================================================
// Hidden Variables
//==================================================================
$form->add_hidden("prev_action", $action);
$form->add_hidden("action", $next_action[$action]);
$form->add_hidden("id", $id);

//-----------------------------------------------
// Add
//-----------------------------------------------
if ($action == 'add_folder' || $action == 'add_entry') {
	$form->add_hidden("site_id", $valid_site);
	$form->add_hidden("parent", $parent);
	$form->add_hidden("node_path", $node_path);
	$form->add_hidden("create_user", $_SESSION["userid"]);
}

//==================================================================
// Title / Name
//==================================================================
$tmp = ($action == 'add_folder' || $entry_type == 1) ? ("Name") : ("Title");
$form->add_element(
	POP_TB::simple_control_group($tmp, new textbox("entry_title", $entry_title, 53))
);

//==================================================================
// Description
//==================================================================
if ($entry_type == 2) {
	if ($FOLDER_OPTS['entry_desc'] == 'show' || ($FOLDER_OPTS['entry_desc'] == 'admin' && $acc_lvl > 2)) {
		$form->add_element(
			POP_TB::simple_control_group("Description", new textarea("entry_desc", $entry_desc, 60, 2))
		);
	}
	else if ($FOLDER_OPTS['entry_desc'] == 'admin' && $acc_lvl <= 2 && trim($entry_desc) != '') {
		$form->add_element(
			POP_TB::simple_control_group("Description", span($entry_desc, array('class' => 'control-label')))
		);	
	}
}
else {
	$form->add_element(
		POP_TB::simple_control_group("Description", new textarea("entry_desc", $entry_desc, 60, 2))
	);	
}

//==================================================================
// Entry Type
//==================================================================
if ($action == 'add_folder') { $tmp = 1; }
else if ($action == 'add_entry') { $tmp = 2; }
else { $tmp = $entry_type; }
$form->add_hidden("entry_type", $tmp);

//==================================================================
// URL Tag/Key
//==================================================================
if ($entry_type == 2) {
	if ($FOLDER_OPTS['url_tag'] == 'show' || ($FOLDER_OPTS['url_tag'] == 'admin' && $acc_lvl > 2)) {
		$form->add_element(
			POP_TB::simple_control_group("URL Tag/Key", new textbox("url_tag", $url_tag))
		);
	}
}
else {
	$form->add_element(
		POP_TB::simple_control_group("URL Tag/Key", new textbox("url_tag", $url_tag))
	);
}

//==================================================================
//==================================================================
// Add OR Edit -> Content Entry
//==================================================================
//==================================================================
if ($action == 'add_entry' || ($action == 'edit' && $entry_type == 2)) {

	//******************************************************
	// Author
	//******************************************************
	if ($FOLDER_OPTS['entry_author'] == 'show' || ($FOLDER_OPTS['entry_author'] == 'admin' && $acc_lvl > 2)) {
		$strsql = "
			select * from site_blog_authors 
			where site_id = ?
			order by author_name
		";
		$authors = qdb_exec('', $strsql, array('i', $site_id), 'id:author_name');
		$ssa_author = new ssa("entry_author", $authors);
		$ssa_author->add_blank(0, '--');
		$ssa_author->selected_value($entry_author);
	
		$form->add_element(
			POP_TB::simple_control_group("Author", $ssa_author)
		);
	}

	//******************************************************
	// Category
	//******************************************************
	if ($FOLDER_OPTS['category'] == 'show' || ($FOLDER_OPTS['category'] == 'admin' && $acc_lvl > 2)) {
		$strsql = "
			select * from site_entry_cats 
			where 
				site_id = ? 
				and folder_id = ?
				and (active = 1 or id = ?) 
			order by category
		";
		$cats = qdb_exec('', $strsql, array('iii', $site_id, $parent, $cat_id), 'id:category');
		$ssa_cats = new ssa("cat_id", $cats);
		$ssa_cats->add_blank(0, 'None');
		$ssa_cats->selected_value($cat_id);
	
		$form->add_element(
			POP_TB::simple_control_group("Category", $ssa_cats)
		);
	}
}

//==================================================================
//==================================================================
// Edit ONLY -> Content Entry
//==================================================================
//==================================================================
if ($action == 'edit' && $entry_type == 2) {
	if ($FOLDER_OPTS['post_date'] == 'show' || ($FOLDER_OPTS['post_date'] == 'admin' && $acc_lvl > 2)) {
		//-----------------------------------------------
		// Post Date
		//-----------------------------------------------
		if (!isset($ssv_status)) {
			if (strtotime($post_date) < 1) { $post_date = $create_date; }
			list($pd_date, $pd_hour, $pd_min, $pd_sec, $pd_ampm) = parse_timestamp($post_date);
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
		$ssa_ampm = new ssa("pd_ampm", $arr_ampm);
		$ssa_ampm->selected_value($pd_ampm);
		
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
}

//==================================================================
//==================================================================
// Add OR Edit -> Content Entry
//==================================================================
//==================================================================
if ($action == 'add_entry' || ($action == 'edit' && $entry_type == 2)) {

	//==================================================================
	// Active?
	//==================================================================
	if ($FOLDER_OPTS['active'] == 'show' || ($FOLDER_OPTS['active'] == 'admin' && $acc_lvl > 2)) {
		if (!isset($active)) { $active = 0; }
		$form->add_element(
			POP_TB::simple_control_group("Active", new checkbox("active", 1, $active))
		);
	}

	//==================================================================
	// Content
	//==================================================================
	if ($FOLDER_OPTS['content'] == 'show' || ($FOLDER_OPTS['content'] == 'admin' && $acc_lvl > 2)) {
		include('frm_content.php');
	}
}

//==================================================================
// Folders Only -> Folder Options
//==================================================================
if ($action == 'add_folder' || $entry_type == 1) {
	if ($acc_lvl > 2) {
		include('frm_folder_opts.php');
	}
}

//==================================================================
// Meta Tags
//==================================================================
if ($action == 'add_entry' || ($action == 'edit' && $entry_type == 2)) {
	if ($FOLDER_OPTS['metadata'] == 'show' || ($FOLDER_OPTS['metadata'] == 'admin' && $acc_lvl > 2)) {

		//------------------------------------------------------------------
		// Convert Meta Data from JSON to Array
		//------------------------------------------------------------------
		if (!empty($metadata)) {
			$metadata = json_decode($metadata, true);
		}

		//------------------------------------------------------------------
		// Start Fieldset
		//------------------------------------------------------------------
		$form->start_fieldset('Meta Tags');

		//------------------------------------------------------------------
		// Display Meta Tags
		//------------------------------------------------------------------
		foreach ($meta_tags as $mt_key => $mt_desc) {
			$tmp_val = (isset($metadata[$mt_key])) ? ($metadata[$mt_key]) : ('');
			$form->add_element(
				POP_TB::simple_control_group($mt_desc, new textarea("metadata[{$mt_key}]", $tmp_val, 50, 3))
			);
		}

		//------------------------------------------------------------------
		// End Fieldset
		//------------------------------------------------------------------
		$form->end_fieldset();
	}
}

//==================================================================
// Save Buttons
//==================================================================
if ($entry_type == 2 || $action == 'add_entry' ) {
	$form->add_element(
		POP_TB::simple_control_group(false, array(
			button('Save', array('name' => 'button_0', 'value' => 'Save', 'type' => 'submit', 'class' => 'btn btn-primary')),
			button('Save and Publish', array('name' => 'button_1', 'value' => 'Save and Publish', 'type' => 'submit', 'class' => 'btn btn-success'))
		))
	);
}
else {
	$form->add_element(POP_TB::save_button());
}

//==================================================================
// Render Form
//==================================================================
$form->render();

