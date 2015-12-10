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
$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Add a blog category", "image" => xml_escape($add_image));

//==================================================================
// Pull a list
//==================================================================
$strsql = "select * from site_blog_cats where blog_id = ? order by category";
$cats = qdb_exec('', $strsql, array('i', $blog_id));

//==================================================================
// Sanitize Records
//==================================================================
format_records($cats, array(
	'category' => 'html_escape'
));

//==================================================================
// Format Records
//==================================================================
foreach ($cats as $key => &$cat) {
	extract($cat);	

	//-----------------------------------------------------
	// Links
	//-----------------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));

	//-----------------------------------------------------
	// Actions
	//-----------------------------------------------------
	if (isset($used_blog_cats[$id])) {
		$cat["actions"] = '--';
	}
	else {
		$cat["actions"] = anchor($delete_link, $delete_image, array('class' => 'btn'));
	}

	//-----------------------------------------------------
	// Create Date
	//-----------------------------------------------------
	$cat["create_date"] = ($create_date != "") ? (mystamp_pretty($create_date)) : ("--");

	//----------------------------------------------
	// Active Status
	//----------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_class = ($active) ? ("label label-success") : ("label");
	$cat["active"] = span($status_msg, array("class" => $status_class));

	//-----------------------------------------------------
	// Category
	//-----------------------------------------------------
	$cat['category'] = anchor($edit_link, $category);

	//-----------------------------------------------------
	// Change ID
	//-----------------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }
}

//==================================================================
// Data Order
//==================================================================
$data_order = array();
$data_order["category"] = "Title";
$data_order["active"] = "Active?";
$data_order["actions"] = ".";

//==================================================================
// Display Records
//==================================================================
$table = new rs_list($data_order, $cats);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "cats_list table table-striped");

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

