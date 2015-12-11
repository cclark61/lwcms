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
$strsql = "select id, site_name from sites order by site_name";
$site_list = qdb_list('', $strsql, "id:site_name"); // Ok
foreach ($site_list as &$item) { $item = html_escape($item); }
if (count($site_list) > 0) {

	//=================================================================
	// Create Form
	//=================================================================
	$form = new form_too($mod_base_url2);
	$form->label("Select a Site");
	$form->attr('.', 'form-horizontal');
	$form->add_hidden("action", "edit");
	
	//=================================================================
	// Site Dropdown
	//=================================================================
	$site_select = new ssa("curr_site_id", $site_list);
	$form->add_element(
		POP_TB::simple_control_group(false, $site_select)
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
	add_gen_message('There are currently no sites to configure.');
}

