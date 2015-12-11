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

//========================================================================
// Top Module Links
//========================================================================
if ($admin_status > 0) {
	$top_mod_links = array();
	$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
	$top_mod_links["links"][] = array(
		"link" => $tmp_link, 
		"desc" => "Add a site", 
		"image" => xml_escape($add_image),
		'class' => 'btn btn-success'
	);
}

//========================================================================
// Pull a list of sites for this user
//========================================================================
$sites = LWCMS::get_site_list();

//========================================================================
// Only One Site?
//========================================================================
if (count($sites) == 1 && !ADMIN_STATUS) {
	header("Location: {$this->html_path}/{$sites[0]['id']}/");
	exit;
}
else if (!$sites) {
	add_gen_message('There are no sites available to you at this time.');
}

//========================================================================
// Sanitize Records
//========================================================================
format_records($sites, array(
	'site_name' => 'html_escape',
	'site_desc' => 'html_escape',
	'site_url' => 'html_escape'
));

//========================================================================
// Manipulate Data
//========================================================================
foreach ($sites as $key => &$site) {
	extract($site);
	$status = false;
	$site_id = $id;

	//---------------------------------------------------------
	// Links
	//---------------------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$view_link = "{$mod_base_url}{$id}/";
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));
	$site["actions"] = anchor($view_link, $open_folder_image, array('class' => 'btn btn-primary'));
	$site["actions"] .= anchor($edit_link, $edit_image, array('class' => 'btn btn-info'));
	$site["actions"] .= anchor($delete_link, $delete_image, array('class' => 'btn btn-danger site_delete'));
	if ($site_url != '') {
		$site["site_url"] = anchor($site_url, $site_url, array('target' => '_blank'));
	}
	$site["site_name"] = div(anchor($view_link, $site_name), array("class" => "site_name"));
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }

	//---------------------------------------------------------
	// Site Description / Site URL
	//---------------------------------------------------------
	fill_if_empty($site['site_desc']);
	fill_if_empty($site['site_url']);

}

//========================================================================
// Show Sites List
//========================================================================
$data_order = array();
//$data_order["id"] = "ID";
$data_order["site_name"] = "Name";
$data_order["site_desc"] = "Desc.";
$data_order["site_url"] = "URL";

if ($admin_status > 0) {
	$data_order["actions"] = "Actions";
}

$table = new rs_list($data_order, $sites);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->display_headers(false);
$table->identify("", "site_list table table-striped");
$table->set_col_attr('site_url', 'class', 'hidden-xs');
$table->set_col_attr('site_desc', 'class', 'hidden-xs hidden-sm');

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

