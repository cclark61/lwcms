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
$top_mod_links["links"][] = array(
	"link" => $tmp_link, 
	"desc" => "Add a folder category", 
	"image" => xml_escape($add_image),
	'class' => 'btn btn-success'
);

//==================================================================
// Pull a list
//==================================================================
$strsql = "select * from site_entry_cats where site_id = ? and folder_id = ? order by category";
$cats = qdb_exec('', $strsql, array('ii', $site_id, $parent));

//==================================================================
// Sanitize Records
//==================================================================
format_records($cats, array(
	'category' => 'html_escape'
));

//==================================================================
// Format Data
//==================================================================
foreach ($cats as $key => &$cat) {
	extract($cat);	

	//---------------------------------------------
	// Links
	//---------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));

	//---------------------------------------------
	// Category
	//---------------------------------------------
	$cat["category"] = anchor($edit_link, $category);

	//---------------------------------------------
	// Delete Link
	//---------------------------------------------
	if (isset($used_content_cats[$id])) {
		$cat["actions"] = '--';
	}
	else {
		$cat["actions"] = anchor($delete_link, $delete_image, array('class' => 'btn btn-danger'));
	}

	//---------------------------------------------
	// Create Date
	//---------------------------------------------
	$cat["create_date"] = ($create_date != "") ? (mystamp_pretty($create_date)) : ("--");
	
	//---------------------------------------------
	// Active Status
	//---------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_style = ($active) ? ("color: green;") : ("color: red;");
	$cat["active"] = span($status_msg, array("style" => $status_style));
	
	//---------------------------------------------
	// Change ID
	//---------------------------------------------
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
$table->render();

