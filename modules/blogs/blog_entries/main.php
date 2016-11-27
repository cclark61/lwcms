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
	"desc" => "Add a blog entry", 
	"image" => xml_escape($add_image),
	'class' => 'btn btn-success'
);

//==================================================================
// Pull a list of categories
//==================================================================
$strsql = "select * from site_blog_cats where blog_id = ?";
$cats = qdb_exec('', $strsql, array('i', $blog_id), "id");

//==================================================================
// Pull a list of authors
//==================================================================
$strsql = "select * from site_blog_authors where site_id = ?";
$authors = qdb_exec('', $strsql, array('i', $site_id), "id");

//==================================================================
// Pull a list
//==================================================================
$strsql = "select * from site_blog_entries where blog_id = ? order by post_date desc";
$entries = qdb_exec('', $strsql, array('i', $blog_id));

//==================================================================
// Sanitize Records
//==================================================================
format_records($entries, array(
	'entry_title' => 'html_escape'
));

//==================================================================
// Format Records
//==================================================================
foreach ($entries as $key => &$entry) {
	extract($entry);

	//---------------------------------------------
	// Links / Action
	//---------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	$revisions_link = add_url_params($mod_base_url, array("action" => "revisions", "id" => $id));
	$entry["edit"] = anchor($edit_link, $edit_image, array('class' => 'btn btn-info'));
	$view_version_link = add_url_params($mod_base_url, array("action" => "view_version", "id" => $id, "version" => 'latest'));
	$tmp_attrs = array(
		'content_link' => $view_version_link, 
		'class' => 'btn btn-primary view_version', 
		'data-toggle' => 'modal', 
		'data-target' => "#revision_modal"
	);

	$entry["actions"] = anchor($revisions_link, $revisions_image, array('class' => 'btn btn-primary'));
	$entry["actions"] .= xhe('a', $view_image, $tmp_attrs);
	//$entry["actions"] .= anchor($edit_link, $edit_image, array('class' => 'btn btn-info'));
	$entry["actions"] .= anchor($delete_link, $delete_image, array('class' => 'btn btn-danger'));

	//---------------------------------------------
	// Dates
	//---------------------------------------------
	$entry["create_date"] = ($create_date != "") ? (mystamp_pretty($create_date)) : ("--");
	$entry["post_date"] = ($post_date != "") ? (mystamp_pretty($post_date)) : ("--");

	//----------------------------------------------
	// Active Status
	//----------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_class = ($active) ? ("label label-success") : ("label label-default");
	$entry["active"] = span($status_msg, array("class" => $status_class));

	//---------------------------------------------
	// Category
	//---------------------------------------------
	$entry["category"] = (isset($cats[$cat_id])) ? ($cats[$cat_id]["category"]) : ("[No Category]");

	//---------------------------------------------
	// Author
	//---------------------------------------------
	$entry["entry_author"] = (isset($authors[$entry_author])) ? ($authors[$entry_author]["author_name"]) : ("[No Author]");

	//---------------------------------------------------------
	// Publish Status
	//---------------------------------------------------------
	$disp_pub_status = ($version_live) ? ('Yes') : ('No');
	$pub_status_class = ($version_live) ? ('label label-success') : ('label label-default');
	$entry["publish_status"] = span($disp_pub_status, array('class' => $pub_status_class));

	//---------------------------------------------
	// Entry Title
	//---------------------------------------------
	$entry['entry_title'] = anchor($edit_link, $entry_title);

	//---------------------------------------------
	// Change ID
	//---------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }

}

//==================================================================
// Sanitize Records
//==================================================================
format_records($entries, array(
	'entry_author' => 'html_escape',
	'category' => 'html_escape'
));

//==================================================================
// Data Order
//==================================================================
$data_order = array();
$data_order["entry_title"] = "Title";
$data_order["post_date"] = "Post Date";
$data_order["entry_author"] = "Author";
$data_order["category"] = "Category";
$data_order["publish_status"] = "Published?";
$data_order["active"] = "Active?";
$data_order["actions"] = "Actions";

//==================================================================
// Display Records
//==================================================================
$table = new rs_list($data_order, $entries);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "entries_list table table-striped");
$table->label($blog_title);
$table->set_col_attr("entry_author", "class", "hidden-xs", false, true);
$table->set_col_attr("category", "class", "hidden-xs", false, true);
$table->set_col_attr("post_date", "class", "hidden-xs", false, true);
$table->set_col_attr("publish_status", "class", "hidden-xs", false, true);
$table->set_col_attr("active", "class", "hidden-xs", false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

//==================================================================
// Include Modal
//==================================================================
include("{$mod_common_dir}/content_versions/version_modal.html");

