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
	// Pull a list of all Users
	//-------------------------------------------------------
	$users = get_non_admin_user_list();
	
	//-------------------------------------------------------
	// Pull a list of all installed Site Modules
	//-------------------------------------------------------
	$app_modules = get_app_modules();
	
	//-------------------------------------------------------
	// Pull Site Info
	//-------------------------------------------------------
	$site_info = get_site_info($curr_site_id);
	$site_name = $site_info["site_name"];

	//-------------------------------------------------------
	// Remove previous entries for this site
	//-------------------------------------------------------
	$del_sql = "delete from site_access where site_id = ?";
	qdb_exec('', $del_sql, array('i', $curr_site_id));

	//-------------------------------------------------------
	// Update Queries
	//-------------------------------------------------------
	$update_queries = array();
	foreach ($users as $tmp_userid => $user) {

		foreach ($app_modules as $sm) {
			$tmp_mod_id = $sm["id"];
			$tmp_var = $tmp_userid . ":" . $tmp_mod_id;
			$acc_lvl = (isset($_POST[$tmp_var]) && $_POST[$tmp_var]) ? ($_POST[$tmp_var]) : (0);
			
			if ($acc_lvl) {
				$strsql = "insert into site_access (site_id, module_id, userid, acc_lvl) values (?, ?, ?, ?)";
				qdb_exec('', $strsql, array('iisi', $curr_site_id, $tmp_mod_id, $tmp_userid, $acc_lvl));
			}
		}
	}
	
	add_action_message("Access privileges for <em>{$site_name}</em> were updated successfully.");
}

//==================================================================
// Redirect
//==================================================================
$redirect_url = $mod_base_url;
redirect($redirect_url);

