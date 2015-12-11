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
if ($acc_lvl > 1) {
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
	$top_mod_links["links"][] = array(
		"link" => $tmp_link, 
		"desc" => "Add a blog", 
		"image" => xml_escape($add_image),
		'class' => 'btn btn-success'
	);
}

//==================================================================
// Pull a list
//==================================================================
$strsql = "select * from site_blogs where site_id = ? order by blog_title";
$blogs = qdb_exec('', $strsql, array('i', $valid_site));

//==================================================================
// Sanitize Records
//==================================================================
format_records($blogs, array(
	'blog_title' => 'html_escape',
	'blog_url' => 'html_escape'
));

//==================================================================
// Format Records
//==================================================================
foreach ($blogs as $key => &$blog) {
	extract($blog);

	//----------------------------------------------
	// Links
	//----------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	$entries_link = "{$mod_base_url}{$id}/entries/";
	$cats_link = "{$mod_base_url}{$id}/cats/";
	$blog["create_date"] = ($create_date != "") ? (mystamp_pretty($create_date)) : ("--");

	if ($acc_lvl > 2) {
		$blog["blog_title"] = anchor($entries_link, $blog_title);
	}

	//----------------------------------------------
	// Actions
	//----------------------------------------------
	$blog["actions"] = anchor($entries_link, $content_image, array('class' => 'btn'));
	if ($acc_lvl > 2) {
		$blog["actions"] .= anchor($cats_link, $cat_image, array('class' => 'btn'));
		$blog["actions"] .= anchor($edit_link, $edit_image, array('class' => 'btn'));
		$blog["actions"] .= anchor($delete_link, $delete_image, array('class' => 'btn'));
	}

	//----------------------------------------------
	// Active Status
	//----------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_class = ($active) ? ("label label-success") : ("label label-default");
	$blog["active"] = span($status_msg, array("class" => $status_class));
	
	//----------------------------------------------
	// Blog URL
	//----------------------------------------------
	if (!empty($blog["blog_url"])) {
		$blog["blog_url"] = anchor($blog["blog_url"], $blog["blog_url"], array('target' => '_blank'));
	}
	else {
		$blog["blog_url"] = '--';
	}

	//----------------------------------------------
	// Change ID
	//----------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }
}

//==================================================================
// Data Order
//==================================================================
$data_order = array();
//$data_order["id"] = "ID";
$data_order["blog_title"] = "Title";
$data_order["blog_url"] = "URL";
//$data_order["create_date"] = "Create Date";
$data_order["active"] = "Active?";
$data_order["actions"] = "Actions";

//==================================================================
// Display Records
//==================================================================
$table = new rs_list($data_order, $blogs);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "events_list table table-striped");
$table->set_col_attr('blog_url', 'class', 'hidden-xs', false, true);
$table->set_col_attr('active', 'class', 'hidden-xs', false, true);
$table->render();

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

