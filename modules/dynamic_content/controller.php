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

//====================================================================
// Include Local Settings
//====================================================================
include('local.var.php');

//====================================================================
// Start Dynamic Content Parameters
//====================================================================
$dc_params = array();

//====================================================================
// Parent
//====================================================================
$parent = (int)$segment_3;

//====================================================================
// Check Parent
//====================================================================
if ($parent) {
	$dc_params["parent"] = $parent;
	$db_params = array('ii', $site_id, $parent);
	$strsql = "select * from {$mod_table} where site_id = ? and id = ?";
	$curr_entry = qdb_exec('', $strsql, $db_params);

	if (count($curr_entry) > 0) {
		$node_path = $curr_entry[0]["node_path"];
		if ($node_path == "") { $node_path = $parent; }
		else { $node_path .= ":" . $parent; }
		$dc_params["node_path"] = $node_path;
	}
}
else {
	$dc_params = array('parent' => 0, 'node_path' => '');
	extract($dc_params);
}

//====================================================================
// Entry Breadcrumbs
//====================================================================
$curr_path = array(anchor($mod_base_url, 'TOP LEVEL'));
if ($node_path) {
	$nodes = explode(":", $node_path);
	$count = count($nodes);
	$in_nodes = '';
	$db_params = array('');
	foreach ($nodes as $node) {
		$db_params[0] .= 'i';
		$db_params[] = $node;
		$in_nodes .= ($in_nodes) ? (', ?') : ('?');
	}
	$strsql = "select * from {$mod_table} where id IN ($in_nodes)";
	$node_recs = qdb_exec('', $strsql, $db_params, "id");
	foreach ($nodes as $node) {
		$node_title = $node_recs[$node]["entry_title"];
		$tmp_link = "{$mod_base_url}{$node}/";
		$curr_path[] = anchor($tmp_link, html_escape($node_title));
	}
}

//====================================================================
// Breadcrumbs
//====================================================================
if ($segment_4 == 'cats' || $action == 'folder_options') {
	$curr_path = [];
}

//====================================================================
// Define Parent ID Constant
//====================================================================
define('PARENT', $parent);
$mod_base_url .= $parent . '/';
$mod_base_url2 = $mod_base_url;

//====================================================================
// Flow Control
//====================================================================
if ($valid_site) {

	switch ($segment_4) {

		//------------------------------------------------------
		// Folder Categories
		//------------------------------------------------------
		case "cats":
			if ($acc_lvl > 2) {
				$mod_title .= " :: Folder Categories";
				$mod_base_url2 = $mod_base_url = "{$mod_base_url}cats/";
				include("entry_cats/controller.php");
			}
			else {
				add_warn_message($access_deny_msg);
				include("main.php");
			}
			break;

		//------------------------------------------------------
		// Entry Actions
		//------------------------------------------------------
		default:
			switch ($this->action) {

				//------------------------------------------------------
				// Add / Confirm Delete
				//------------------------------------------------------
				case "add_folder":
				case "add_entry":
				case "confirm_delete":
					if ($acc_lvl > 1) {
						$pull_from_db = true;
						include("form_controller.php");
					}
					else {
						add_warn_message($access_deny_msg);
						include("main.php");
					}
					break;

				//------------------------------------------------------
				// Folder Options
				//------------------------------------------------------
				case "folder_options":
					if ($acc_lvl > 2) {
						$pull_from_db = true;
						include("form_controller.php");
					}
					else {
						add_warn_message($access_deny_msg);
						include("main.php");
					}
					break;

				//------------------------------------------------------
				// View, iFrame, Edit, Preview
				//------------------------------------------------------
				case "view":
				case "iframe":
				case "edit":
				case "preview":
				case 'revisions':
				case 'view_version':
					$pull_from_db = true;
					include("form_controller.php");
					break;

				//------------------------------------------------------
				// Insert / Delete
				//------------------------------------------------------
				case "insert":
				case "delete":
					if ($acc_lvl > 1) {
						include("db_action.php");
					}
					else {
						add_warn_message($access_deny_msg);
						include("main.php");
					}
					break;

				//------------------------------------------------------
				// Update
				//------------------------------------------------------
				case "update":
				case "update_folder_opts":
					include("db_action.php");
					break;

				//------------------------------------------------------
				// Show Entries
				//------------------------------------------------------
				default:
					include("main.php");
					break;
			}
			break;
	}
}
else {
	redirect($page_url);
}

