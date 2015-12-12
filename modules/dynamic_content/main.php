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

//*******************************************************************
// Top Module Links
//*******************************************************************
if ($acc_lvl > 1) {
	$top_mod_links = array();
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add_folder"), true);
	$top_mod_links["links"][] = array(
		"link" => $tmp_link, 
		"desc" => "Add a folder", 
		"image" => xml_escape($add_folder_image),
		'class' => 'btn btn-success'
	);
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add_entry"), true);
	$top_mod_links["links"][] = array(
		"link" => $tmp_link, 
		"desc" => "Add an entry", 
		"image" => xml_escape($add_file_image),
		'class' => 'btn btn-success'
	);
	if ($acc_lvl > 2) {
		$tmp_link = "{$mod_base_url2}cats/";
		$top_mod_links["links"][] = array(
			"link" => $tmp_link, 
			"desc" => "Categories", 
			"image" => xml_escape($cat_image),
			'class' => 'btn btn-info'
		);
		$fo_link = add_url_params($mod_base_url, array("action" => "folder_options", "id" => $parent), true);
		$top_mod_links["links"][] = array(
			"link" => $fo_link, 
			"desc" => "Folder Options", 
			"image" => xml_escape($cat_image),
			'class' => 'btn btn-info'
		);
	}
}

//*******************************************************************
// Check if current selected entry is a folder or top level (0)
//*******************************************************************
if ($parent != 0) {
	$strsql = "
		select count(*) as count from {$mod_table} where 
		site_id = ? and id = ? and entry_type = 1
	";
	$count = qdb_lookup('', $strsql, 'count', array('ii', $valid_site, $parent)); // Ok
	if (!$count) {
		redirect($mod_home_redir_url);
	}
}

//*******************************************************************
//*******************************************************************
// Show Folders
//*******************************************************************
//*******************************************************************
$strsql = "
	select * from {$mod_table} 
	where 
		site_id = ? and parent = ?
		and entry_type = 1
	order by entry_title
";
$entries = qdb_exec('', $strsql, array('ii', $valid_site, $parent));

//===================================================================
// Sanitize Records
//===================================================================
format_records($entries, array(
	'entry_title' => 'html_escape',
	'url_tag' => 'html_escape'
));

//===================================================================
// Format Records
//===================================================================
foreach ($entries as $key => &$entry) {
	extract($entry);

	//----------------------------------------------
	// Links
	//----------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	$sub_entries_link = "{$mod_home_url}{$id}/";

	//----------------------------------------------
	// Actions
	//----------------------------------------------
	$entry["actions"] = anchor($edit_link, $edit_image, array('class' => 'btn btn-info'));
	if ($acc_lvl > 1) {
		$entry["actions"] .= anchor($delete_link, $delete_image, array('class' => 'btn btn-danger'));
	}

	//----------------------------------------------
	// URL Tag
	//----------------------------------------------
	fill_if_empty($entry["url_tag"]);

	//----------------------------------------------
	// Entry Title Link
	//----------------------------------------------
	$entry["entry_title"] = anchor($sub_entries_link, $folder_image . $entry_title);

	//----------------------------------------------
	// Highlight changed row
	//----------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }
}

//===================================================================
// Data Order
//===================================================================
$data_order = array();
$data_order["entry_title"] = "Folder Name";
$data_order["url_tag"] = "URL Tag/Key";
$data_order["actions"] = "Actions";

//===================================================================
// Display Records
//===================================================================
$table = new rs_list($data_order, $entries);
$table->empty_message("--");
if (isset($change_row)) {
	$table->set_row_attr($change_row, "class", "hl_change");
	unset($change_row);
}
$table->identify("", "table table-striped");
$table->label('Folders');
$table->set_col_attr("entry_type", "class", "icon_col");
$table->set_col_attr("url_tag", "class", "hidden-xs", false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

//*******************************************************************
//*******************************************************************
// Show Entries
//*******************************************************************
//*******************************************************************

//===================================================================
// Pull a list of authors
//===================================================================
$strsql = "select * from site_blog_authors where site_id = ?";
$authors = qdb_exec('', $strsql, array('i', $site_id), "id");

//===================================================================
// Pull a list of categories
//===================================================================
$strsql = "select * from site_entry_cats where folder_id = ?";
$cats = qdb_exec('', $strsql, array('i', $parent), "id:category");

//===================================================================
// Pull Content Entries
//===================================================================
$strsql = "
	select * from {$mod_table} 
	where 
		site_id = ? and parent = ?
		and entry_type = 2
	order by post_date desc, create_date desc
";
$entries = qdb_exec('', $strsql, array('ii', $valid_site, $parent));

//===================================================================
// Sanitize Records
//===================================================================
format_records($entries, array(
	'entry_title' => 'html_escape',
	'url_tag' => 'html_escape'
));

//===================================================================
// Format Data
//===================================================================
foreach ($entries as $key => &$entry) {
	extract($entry);

	//---------------------------------------------------------
	// Links
	//---------------------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	$preview_link = add_url_params($mod_base_url, array("action" => "preview", "id" => $id));
	$revisions_link = add_url_params($mod_base_url, array("action" => "revisions", "id" => $id));
	$view_version_link = add_url_params($mod_base_url, array("action" => "view_version", "id" => $id, "version" => 'latest'));
	$tmp_attrs = array(
		'content_link' => $view_version_link, 
		'class' => 'btn btn-primary view_version', 
		'data-toggle' => 'modal', 
		'data-target' => "#revision_modal"
	);

	//---------------------------------------------------------
	// Actions
	//---------------------------------------------------------
	$entry["actions"] = anchor($revisions_link, $revisions_image, array('class' => 'btn btn-primary'));
	$entry["actions"] .= anchor('#', $view_image, $tmp_attrs);
	$entry["actions"] .= anchor($edit_link, $edit_image, array('class' => 'btn btn-info'));
	if ($acc_lvl > 1) {
		$entry["actions"] .= anchor($delete_link, $delete_image, array('class' => 'btn btn-danger'));
	}

	//----------------------------------------------
	// URL Tag
	//----------------------------------------------
	if ($url_tag == '') { $entry["url_tag"] = '--'; }

	//---------------------------------------------------------
	// Author
	//---------------------------------------------------------
	$entry["entry_author"] = (isset($authors[$entry_author])) ? ($authors[$entry_author]["author_name"]) : ('--');

	//---------------------------------------------------------
	// Category
	//---------------------------------------------------------
	$entry["cat_id"] = (isset($cats[$cat_id])) ? ($cats[$cat_id]) : ('--');

	//---------------------------------------------------------
	// Modify Date
	//---------------------------------------------------------
	$mod_date_stamp = strtotime($mod_date);
	if ($mod_date_stamp > 0) {
		$entry["mod_date"] = date(DEFAULT_TIMESTAMP, $mod_date_stamp);
	}
	else {
		$entry["mod_date"] = '--';
	}

	//---------------------------------------------------------
	// Post Date
	//---------------------------------------------------------
	$post_date_stamp = strtotime($post_date);
	if ($post_date_stamp > 0) {
		$entry["post_date"] = date(DEFAULT_TIMESTAMP, $post_date_stamp);
	}
	else {
		$entry["post_date"] = '--';
	}

	//---------------------------------------------------------
	// Active Status
	//---------------------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_class = ($active) ? ("label label-success") : ("label label-default");
	$entry["active"] = span($status_msg, array("class" => $status_class));

	//---------------------------------------------------------
	// Publish Status
	//---------------------------------------------------------
	$disp_pub_status = ($version_live) ? ('Yes') : ('No');
	$pub_status_class = ($version_live) ? ('label label-success') : ('label label-default');
	$entry["publish_status"] = span($disp_pub_status, array('class' => $pub_status_class));

	//---------------------------------------------------------
	// Highlight changed row
	//---------------------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }

	//---------------------------------------------------------
	// Post Title
	//---------------------------------------------------------
	$entry['entry_title'] = anchor($edit_link, $cont_ent_image . $entry_title);
}

//===================================================================
// Sanitize Records
//===================================================================
format_records($entries, array(
	'cat_id' => 'html_escape',
	'entry_author' => 'html_escape'
));

//===================================================================
// Data Order
//===================================================================
$data_order = array();
$data_order["entry_title"] = "Title";
$data_order["url_tag"] = "URL Tag/Key";
$data_order["entry_author"] = "Author";
$data_order["cat_id"] = "Category";
$data_order["post_date"] = "Post Date";
$data_order["publish_status"] = "Published?";
$data_order["active"] = "Active?";
$data_order["actions"] = "Actions";

//===================================================================
// Display Records
//===================================================================
$table = new rs_list($data_order, $entries);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "entry_list table table-striped");
$table->label('Entries');
$table->set_col_attr("url_tag", "class", "hidden-xs hidden-sm", false, true);
$table->set_col_attr("entry_author", "class", "hidden-xs hidden-sm", false, true);
$table->set_col_attr("cat_id", "class", "hidden-xs hidden-sm", false, true);
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

