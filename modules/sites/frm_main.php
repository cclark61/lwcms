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

//==================================================================
// Hidden Variables
//==================================================================
$form->add_hidden("action", $next_action[$action]);
$form->add_hidden("id", $id);

//==================================================================
// Name
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Name", new textbox("site_name", $site_name, 40))
);

//==================================================================
// Description
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Description", new textarea("site_desc", $site_desc, 70, 3))
);

//==================================================================
// URL
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("URL", new textbox("site_url", $site_url, 40) . " (Optional)")
);

//==================================================================
// Documebnt Root
//==================================================================
$txt_dr = new textbox("document_root", $document_root, 70);
$txt_dr->attr('.', 'wide');
$form->add_element(
	POP_TB::simple_control_group("Site Document Root", $txt_dr . " (Optional)")
);

//==================================================================
// Static Content Directory
//==================================================================
$txt_scd = new textbox("content_dir", $content_dir, 70);
$txt_scd->attr('.', 'wide');
$form->add_element(
	POP_TB::simple_control_group("Static Content Directory", $txt_scd . " (Optional)")
);

//==================================================================
// Cache Dynamic Content?
//==================================================================
$form->add_element(
	POP_TB::simple_control_group('Cache Dynamic Content', new checkbox('cache_dynamic_content', "1", $cache_dynamic_content))
);

//==================================================================
// Active Modules
//==================================================================
$form->start_fieldset("Active Site Modules");

//----------------------------------------------
// Pull a list of Site Modules
//----------------------------------------------
$strsql = "select * from app_modules order by mod_desc";
$app_modules = qdb_list('', $strsql); // Ok

if ($action == "edit") {

	//----------------------------------------------
	// Pull all active modules for this site
	//----------------------------------------------
	$strsql = "select * from active_site_modules where site_id = ?";
	$active_modules = qdb_exec('', $strsql, array('i', $id), "module_id");
}
else { $active_modules = array(); }

//----------------------------------------------
// Active Module Checkboxes
//----------------------------------------------
$str_mods = '';
foreach ($app_modules as $smod) {
	$checked = (isset($active_modules[$smod["id"]])) ? (1) : (0);
	$form->add_element(
		POP_TB::simple_control_group($smod['mod_desc'], new checkbox("site_mod_" . $smod["id"], "1", $checked))
	);

}

//==================================================================
//==================================================================
$form->end_fieldset();

//==================================================================
// Save Button
//==================================================================
$form->add_element(POP_TB::save_button());

//==================================================================
// Render Form
//==================================================================
$form->render();

