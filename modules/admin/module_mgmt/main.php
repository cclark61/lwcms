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

//=================================================================
// Top Module Links
//=================================================================
$top_mod_links = array();
$tmp_link = add_url_params($mod_base_url2, array("action" => "add"), true);
$top_mod_links["links"][] = array("link" => $tmp_link, "desc" => "Install or Upgrade a Module", "image" => xml_escape($add_image));

//=================================================================
// Module List from Database
//=================================================================
$strsql = "select * from app_modules order by mod_desc";
$recs = qdb_list('', $strsql);

//=================================================================
// Sanitize Records
//=================================================================
format_records($recs, array(
	'phrase' => 'html_sanitize',
	'mod_desc' => 'html_sanitize',
	'mod_dir' => 'html_sanitize',
	'version' => 'html_sanitize',
	'content_dir' => 'html_sanitize'
));

//=================================================================
// Check for Installable Modules
//=================================================================
foreach ($recs as &$rec) {
	extract($rec);

	//-----------------------------------------------
	// Links
	//-----------------------------------------------
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));

	if (in_array($phrase, $system_modules)) {
		$rec["actions"] = '--';
		$rec['version'] = $_SESSION['version'];
	}
	else {
		$rec["actions"] = anchor($delete_link, $delete_image, array('class' => 'btn'));
	}

	//-----------------------------------------------
	// Version
	//-----------------------------------------------
	fill_if_empty($rec['version']);
	fill_if_empty($rec['content_dir']);

	//-----------------------------------------------
	// Change ID
	//-----------------------------------------------
	if (isset($change_id) && $id == $change_id) { $change_row = $key; }
}

//=================================================================
// Data Format
//=================================================================
$data_order = array();
$data_order["mod_desc"] = "Module";
$data_order["version"] = "Version";
$data_order["phrase"] = "Phrase";
$data_order["mod_dir"] = "Module Directory";
//$data_order["image"] = "Image";
$data_order["content_dir"] = "Content Directory";
$data_order["actions"] = "Actions";

//=================================================================
// Output Records
//=================================================================
$table = new rs_list($data_order, $recs);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "table table-striped");
$table->set_col_attr('phrase', 'class', 'hidden-xs', false, true);
$table->set_col_attr('mod_dir', 'class', 'hidden-xs', false, true);
$table->set_col_attr('content_dir', 'class', 'hidden-xs', false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

