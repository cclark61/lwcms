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
// Check for form key
//=================================================================
$do_trans = check_and_clear_form_key($this, "form_key", $form_key);
if ($do_trans) {

	//-------------------------------------------------------
	// Pull a list of all Sites
	//-------------------------------------------------------
	$sites = qdb_list('', "select * from sites", "id"); // Ok
	
	//-------------------------------------------------------
	// Pull a list of all installed Site Modules
	//-------------------------------------------------------
	$app_modules = AppModules::get();
	
	//-------------------------------------------------------
	// Pull User Info
	//-------------------------------------------------------
	$user_info = get_user_info($user);
	$full_name = $user_info["full_name"];

	//-------------------------------------------------------
	// Remove previous entries for this user
	//-------------------------------------------------------
	$del_sql = "delete from site_access where userid = ?";
	qdb_exec('', $del_sql, array('s', $user));

	//-------------------------------------------------------
	// Update Queries
	//-------------------------------------------------------
	$update_queries = array();
	foreach ($sites as $site) {
		$tmp_site_id = $site["id"];

		foreach ($app_modules as $sm) {
			$tmp_mod_id = $sm["id"];
			$tmp_var = $tmp_site_id . ":" . $tmp_mod_id;
			$acc_lvl = (isset($_POST[$tmp_var]) && $_POST[$tmp_var]) ? ($_POST[$tmp_var]) : (0);
			
			if ($acc_lvl) {
				$strsql = "insert into site_access (site_id, module_id, userid, acc_lvl) values (?, ?, ?, ?)";
				qdb_exec('', $strsql, array('iisi', $tmp_site_id, $tmp_mod_id, $user, $acc_lvl));
			}
		}
	}
	
	add_action_message("Access privileges for <em>{$full_name}</em> were updated successfully.");
}

//==================================================================
// Redirect
//==================================================================
$redirect_url = $mod_base_url;
redirect($redirect_url);

