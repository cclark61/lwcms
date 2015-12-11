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

//=============================================================================
//=============================================================================
// Generic Function Plugin for LWCMS
//=============================================================================
//=============================================================================

//*****************************************************************************
//*****************************************************************************
// Parse Timestamp Function
//*****************************************************************************
//*****************************************************************************
function parse_timestamp($stamp)
{
	$return_parts = false;
	$parts = explode(" ", $stamp);
	if (count($parts) > 1) {
		$time_parts = explode(":", $parts[1]);
		if (count($time_parts) > 1) {
			$hour = $time_parts[0];
			if ($hour != 0 && $hour != 12) { $hour %= 12; }
			$min = $time_parts[1];
			$sec = (count($time_parts) > 2) ? ($time_parts[2]) : (false);
			$ampm = ($time_parts[0] > 11) ? ("pm") : ("am"); 
			$date = transform_date($parts[0], "sql", "m/d/y");
			
			$return_parts = array($date, $hour, $min, $sec, $ampm);
		}
	}
	return $return_parts;
}

//*****************************************************************************
//*****************************************************************************
// Check Content Directories Function
//*****************************************************************************
//*****************************************************************************
function check_content_dirs($main_content_dir, $mod_sub_dir)
{
	$ret_vals = array();
	$dir_status = 0;
	$messages = array();
	$full_content_dir = "";
	
	if ($main_content_dir == "") {
		$messages[] = "Site content directory is not set!!";
		$dir_status = 1;
	}
	else if (!is_dir($main_content_dir)) {
		$messages[] = "Site content directory is INVALID!!";
		$dir_status = 2;
	}
	else {
		clean_dir($main_content_dir, false, true);
		if (isset($mod_sub_dir) && $mod_sub_dir != "") {
			clean_dir($mod_sub_dir, true, true);
			$full_content_dir = $main_content_dir . "/" . $mod_sub_dir;
		}
		else { $full_content_dir = $main_content_dir; }
		
		if (!file_exists($full_content_dir) || !is_dir($full_content_dir)) {
			$messages[] = "Module content directory ($mod_sub_dir) does not exist!";
			$dir_status = 3;
		}
		else if (!is_writeable($full_content_dir)) {
			$messages[] = "Module content directory ($mod_sub_dir) is not writable!";
			$dir_status = 4;
		}
	}
	
	$ret_vals["dir_status"] = $dir_status;
	$ret_vals["messages"] = $messages;
	$ret_vals["full_content_dir"] = $full_content_dir;
	
	return $ret_vals;
}

//*****************************************************************************
//*****************************************************************************
// Create Module Content Directory Function
//*****************************************************************************
//*****************************************************************************
function create_module_content_dir($main_content_dir, $mod_sub_dir)
{
	$ret_vals = check_content_dirs($main_content_dir, $mod_sub_dir);
	$full_content_dir = $ret_vals["full_content_dir"];
	if (!is_dir($full_content_dir)) {
		$mkdir_status = mkdir($full_content_dir, 0775);

		// Check Make Directory Status
		if ($mkdir_status) {
			return array('action_message' => 'Module content directory created successfully!');
		}
		else {
			return array('warn_message' => 'Module content directory could not be created!');
		}
	}
	
	return true;
}

//*****************************************************************************
//*****************************************************************************
// Check if Database Table exists Function
//*****************************************************************************
//*****************************************************************************
function lwcms_db_table_exists($table)
{
	$db = $_SESSION[$_SESSION["lwcms_ds"]]["source"];
	$strsql = "show tables from {$db} where Tables_in_{$db} = ?";
	$tables = qdb_exec($_SESSION["lwcms_ds"], $strsql, array('s', $table));
	return ($tables) ? (true) : (false);
}

//*****************************************************************************
//*****************************************************************************
// Check if Database Table Field exists Function
//*****************************************************************************
//*****************************************************************************
function lwcms_db_table_field_exists($table, $field)
{
	if (lwcms_db_table_exists($table)) {
		$strsql = "show columns from {$table}";
		$columns = qdb_list($_SESSION["lwcms_ds"], $strsql, "Field:Field");
		
		return (isset($columns[$field])) ? (true) : (false);
	}
	else { return false; }
}

//*****************************************************************************
//*****************************************************************************
// lwcms_get_site_access()
// Function to pull a list of sites a user has access to
//*****************************************************************************
//*****************************************************************************
function lwcms_get_site_access()
{
	$strsql = "
		select 
			a.* 
		from 
			sites a, 
			site_access b
		where 
			a.id = b.site_id 
			and b.userid = ?
		group by 
			a.id
		order by 
			a.site_name
	";
	return qdb_exec('', $strsql, array('s', $_SESSION['userid']));
}

//*****************************************************************************
//*****************************************************************************
// lwcms_get_site_mod_access()
// Function to get user module access levels for a given site
//*****************************************************************************
//*****************************************************************************
function lwcms_get_site_mod_access($site_id, $site_name)
{
	$strsql = "
		select * from 
			app_modules a, 
			active_site_modules b, 
			site_access c
		where 
			a.id = b.module_id 
			and b.module_id = c.module_id
			and b.site_id = c.site_id 
			and b.site_id = ? 
			and c.userid = ?
		group by 
			a.id 
		order by 
			a.mod_desc
	";
	return qdb_exec('', $strsql, array('is', $site_id, $_SESSION['userid']), 'phrase:acc_lvl');
}

//*****************************************************************************
//*****************************************************************************
// Get a User's Info
//*****************************************************************************
//*****************************************************************************
function get_user_info($userid)
{
	$strsql = "
		select 
			*, concat(first_name, ' ', last_name) as full_name 
		from 
			users 
		where 
			userid = ?
	";
	return qdb_first_row('', $strsql, array('s', $userid));
}

//*****************************************************************************
//*****************************************************************************
// Get a Site's Info
//*****************************************************************************
//*****************************************************************************
function get_site_info($site_id)
{
	$strsql = "select * from sites where id = ?";
	return qdb_first_row('', $strsql, array('i', $site_id));
}

//*****************************************************************************
//*****************************************************************************
// Get Non-Admin User List
//*****************************************************************************
//*****************************************************************************
function get_non_admin_user_list($index='userid:full_name')
{
	$strsql = "
		select 
			userid, concat(first_name, ' ', last_name) as full_name 
		from 
			users 
		where 
			userid != 'admin' 
			and disabled = 0 
			and admin = 0
		order by
			full_name, userid
	";
	return qdb_list('', $strsql, $index); // Ok
}

//*****************************************************************************
//*****************************************************************************
// Save Content Version
//*****************************************************************************
//*****************************************************************************
function save_content_version($type, $entry_id, $content, $user, $id=false)
{
	load_plugin('content_version');
    $cv = new content_version();
	//$cv->print_only();
	$cv->set_field_data('content_type', $type);
	$cv->set_field_data('create_user', $user);
	$cv->set_field_data('entry_id', $entry_id);
	$cv->set_field_data('raw_content', $content);
	return $cv->save($id);
}

//*****************************************************************************
//*****************************************************************************
// Get Content Versions
//*****************************************************************************
//*****************************************************************************
function get_content_versions($type, $entry_id, $user=false)
{
	$params = array('si', $type, $entry_id);
	$strsql = "select * from content_versions where content_type = ? and entry_id = ?";
	if ($user) {
		$strsql .= ' and create_user = ?';
		$params[0] .= 's';
		$params[] = $user;
	}
	$strsql .= ' order by id desc';
	//print $strsql ; print_array($params);
	return qdb_exec('', $strsql, $params);
}

