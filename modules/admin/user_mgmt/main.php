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
// Top Module Links
//==================================================================
$top_mod_links = array();
$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Add a User", "image" => xml_escape($add_image));

//==================================================================
// Pull a list of users
//==================================================================
$strsql = "select * from users where userid != 'admin' order by last_name, first_name";
$users = qdb_list('', $strsql); // Ok

//==================================================================
// Sanitize Records
//==================================================================
format_records($users, array(
	'userid' => 'html_escape',
	'first_name' => 'html_escape',
	'last_name' => 'html_escape'
));

//==================================================================
// Format Records
//==================================================================
foreach ($users as $key => &$user) {
	extract($user);
	
	//**************************************************************************
	// Links
	//**************************************************************************
    $edit_link = add_url_params($mod_base_url, array("action" => "edit", "curr_userid" => $userid));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "curr_userid" => $userid));
	$user["edit"] = anchor($edit_link, $edit_image);
	
	if ($user["admin"] > 0) {
		$user["actions"] = "--";
	}
	else {
		$user["actions"] = anchor($delete_link, $delete_image, array('class' => 'btn'));
	}
	
	//**************************************************************************
	// Permissions
	//**************************************************************************
	
	//------------------------------------------
	// Admin
	//------------------------------------------
	if (isset($admin) && $admin == 1) {
		$user["admin"] = span("Yes", array('class' => 'label label-success'));
	}
	else {
		$user["admin"] = span("No", array('class' => 'label'));
	}

	//------------------------------------------
	// Active?
	//------------------------------------------
	if (isset($disabled) && $disabled == 1) {
		$user["disabled"] = span("No", array('class' => 'label label-important'));
	}
	else {
		$user["disabled"] = span("Yes", array('class' => 'label label-success'));
	}

	//**************************************************************************
	// User Name / User ID
	//**************************************************************************
	$user['user_name'] = anchor($edit_link, "{$first_name} {$last_name}");
	$user['userid'] = anchor($edit_link, $userid);
}

//==================================================================
// Output Records
//==================================================================
$data_order = array();
$data_order["userid"] = "User ID";
$data_order["user_name"] = "Name";
$data_order["admin"] = "Admin";
$data_order["disabled"] = "Active?";
$data_order["actions"] = "Actions";

$table = new rs_list($data_order, $users);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "table table-striped");
$table->set_col_attr('admin', 'class', 'hidden-xs', false, true);
$table->set_col_attr('disabled', 'class', 'hidden-xs', false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

