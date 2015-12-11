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
// Back Link
//=================================================================
$back_link = $mod_base_url;

//=================================================================
// All Sites
//=================================================================
$strsql = "select * from sites";
$sites = qdb_list('', $strsql, "id"); // Ok

//=================================================================
// Sanitize Records
//=================================================================
format_records($sites, array(
	'site_name' => 'html_escape',
	'site_desc' => 'html_escape',
	'site_url' => 'html_escape'
));

//=================================================================
// Installed Site Modules
//=================================================================
$app_modules = get_app_modules();

//=================================================================
// Site Access for this user
//=================================================================
$strsql = "select *, concat(site_id, ':', module_id) as acc_key from site_access where userid = ?";
$site_access = qdb_exec('', $strsql, array('s', $curr_userid), "acc_key:acc_lvl");

//=================================================================
// Active Site Modules
//=================================================================
$strsql = "select *, concat(site_id, ':', module_id) as acc_key from active_site_modules";
$acm = qdb_list('', $strsql, "acc_key"); // Ok

//=================================================================
// User Info
//=================================================================
$strsql = "select userid, concat(first_name, ' ', last_name) as full_name from users where userid = ?";
$user_info = qdb_exec('', $strsql, array('s', $curr_userid));

//=================================================================
// Are there Sites, Users, and Modules
//=================================================================
if ($sites && $app_modules && $user_info) {

	//--------------------------------------------
	// User Info Display
	//--------------------------------------------
	$user_disp = html_sanitize($user_info[0]["full_name"]) . " ({$curr_userid})";

	//--------------------------------------------
	// Create Form
	//--------------------------------------------
	$form = new form_too($mod_base_url2);
	$this->clear_mod_var("form_key");
	$this->set_mod_var("form_key", $form->use_key());
	$form->label("Access Control for: <em>{$user_disp}</em>");
	$form->attr('.', 'form-horizontal wide-labels');

	$form->add_hidden("action", "update");
	$form->add_hidden("user", $curr_userid);

	//--------------------------------------------
	// Sites
	//--------------------------------------------
	foreach ($sites as $site) {
		$tmp_site_id = $site["id"];
		$form->start_fieldset($site["site_name"]);

		//--------------------------------------------
		// Modules
		//--------------------------------------------
		foreach ($app_modules as $sm) {
			$site_mod_key = $tmp_site_id . ":" . $sm["id"];
			if (isset($acm[$site_mod_key])) {
				$tmp_value = (isset($site_access[$site_mod_key])) ? ($site_access[$site_mod_key]) : (0);
				$tmp_elem = new ssa($site_mod_key, $access_levels);
				$tmp_elem->selected_value($tmp_value);
			}
			else {
				$tmp_elem = span("--", array("style" => "color: gray;"));
			}

			$form->add_element(
				POP_TB::simple_control_group(html_escape($sm["mod_desc"]), $tmp_elem)
			);
		}
		$form->end_fieldset();
	}

	//--------------------------------------------
	// Save Button
	//--------------------------------------------
	$form->add_element(POP_TB::save_button());

	//--------------------------------------------
	// Render Form
	//--------------------------------------------
	$form->render();
}
else {
	add_gen_message('There are currently no sites available for to this user.');
}

