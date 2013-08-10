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
// All Users
//=================================================================
$users = get_non_admin_user_list();
//==================================================================
// Sanitize Records
//==================================================================
foreach ($users as &$item) { $item = html_escape($item); }

//=================================================================
// Installed Site Modules
//=================================================================
$app_modules = get_app_modules();

//=================================================================
// Access privileges for this site
//=================================================================
$strsql = "select *, concat(userid, ':', module_id) as acc_key from site_access where site_id = ?";
$site_access = qdb_exec('', $strsql, array('i', $curr_site_id), "acc_key:acc_lvl");

//=================================================================
// Active Site Modules
//=================================================================
$strsql = "select *, concat(site_id, ':', module_id) as acc_key from active_site_modules";
$acm = qdb_list('', $strsql, "acc_key"); // Ok

//=================================================================
// Site Info
//=================================================================
$site_info = get_site_info($curr_site_id);

//=================================================================
// Are there Sites, Users, and Modules
//=================================================================
if ($users && $app_modules && $site_info) {

	//--------------------------------------------
	// Site Info Display
	//--------------------------------------------
	$site_disp = html_sanitize($site_info["site_name"]);

	//--------------------------------------------
	// Create Form
	//--------------------------------------------
	$form = new form_too($mod_base_url2);
	$this->clear_mod_var("form_key");
	$this->set_mod_var("form_key", $form->use_key());
	$form->label("Access Control for: <em>{$site_disp}</em>");
	$form->attr('.', 'form-horizontal wide-labels');
	
	$form->add_hidden("action", "update");
	$form->add_hidden("curr_site_id", $curr_site_id);

	//--------------------------------------------
	// Users
	//--------------------------------------------
	foreach ($users as $tmp_userid => $user_name) {

		$form->start_fieldset("{$user_name} ($tmp_userid)");

		//--------------------------------------------
		// Modules
		//--------------------------------------------
		foreach ($app_modules as $sm) {
			$user_mod_key = $tmp_userid . ":" . $sm["id"];
			$site_mod_key = $curr_site_id . ":" . $sm["id"];
			if (isset($acm[$site_mod_key])) {
				$tmp_value = (isset($site_access[$user_mod_key])) ? ($site_access[$user_mod_key]) : (0);
				$tmp_elem = new ssa($user_mod_key, $access_levels);
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
	add_gen_message('There are currently no users to configure for this site.');
}

?>
