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

//***************************************************
// Top Module Links
//***************************************************
$top_mod_links = array();
$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Add an author", "image" => xml_escape($add_image));

//***************************************************
// Pull Authors
//***************************************************
$strsql = "select * from site_blog_authors where site_id = ? order by author_name";
$authors = qdb_exec('', $strsql, array('i', $site_id));

//***************************************************
// Pull a list of blogs
//***************************************************
$strsql = "select * from site_blogs where site_id = ?";
$blogs = qdb_exec('', $strsql, array('i', $site_id), 'id:blog_title');

//***************************************************
// Sanitize Records
//***************************************************
format_records($authors, array(
	'author_name' => 'html_escape'
));

//***************************************************
// Format Data
//***************************************************
foreach ($authors as $key => &$author) {
	extract($author);	
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	//$authors[$key]["edit"] = anchor($edit_link, $edit_image);

	if (isset($used_blog_authors[$id]) || isset($used_content_authors[$id])) {
		$authors[$key]["delete"] = '--';
	}
	else {
		$authors[$key]["delete"] = anchor($delete_link, $delete_image, array('class' => 'btn'));
	}

	if (isset($change_id) && $id == $change_id) { $change_row = $key; }
	if ($blog_id) {
		$authors[$key]["blog_id"] = (isset($blogs[$blog_id])) ? ($blogs[$blog_id]) : ('??');
	}
	else { $authors[$key]["blog_id"] = 'All'; }

	// Name
	$author['author_name'] = anchor($edit_link, $author_name);
}

//***************************************************
// Sanitize Records
//***************************************************
format_records($authors, array(
	'blog_id' => 'html_escape'
));

//***************************************************
// Output Records
//***************************************************
$data_order = array();
$data_order["author_name"] = "Author";
$data_order["blog_id"] = "Blog";
//$data_order["edit"] = ".";
$data_order["delete"] = ".";

$table = new rs_list($data_order, $authors);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "authors_list table table-striped");
$table->set_col_attr('blog_id', 'class', 'hidden-xs', false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

