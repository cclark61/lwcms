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
$top_mod_links["links"][] = array(
	"link" => $tmp_link, 
	"desc" => "Add a Testimonial", 
	"image" => xml_escape($add_image),
	'class' => 'btn btn-success'
);

//***************************************************
// Pull Records
//***************************************************
$strsql = "select * from testimonials where site_id = ? order by id";
$recs = qdb_exec($mod_ds, $strsql, array('i', $site_id));

//***************************************************
// Format Records
//***************************************************
foreach ($recs as $key => &$rec) {
	extract($rec);	
	$edit_link = add_url_params($mod_base_url, array("action" => "edit", "id" => $id));
	$delete_link = add_url_params($mod_base_url, array("action" => "confirm_delete", "id" => $id));

	if ($acc_lvl < 2) {
		$rec["delete"] = '--';
	}
	else {
		$rec["delete"] = anchor($delete_link, $delete_image, array('class' => 'btn btn-danger'));
	}

	if (isset($change_id) && $id == $change_id) { $change_row = $key; }

	//----------------------------------------------
	// Active Status
	//----------------------------------------------
	$status_msg = ($active) ? ("Yes") : ("No");
	$status_class = ($active) ? ("label label-success") : ("label label-default");
	$rec["active"] = span($status_msg, array("class" => $status_class));

	//----------------------------------------------
	// Name
	//----------------------------------------------
	$rec['person_name'] = anchor($edit_link, $person_name);
}

//***************************************************
// Output Records
//***************************************************
$data_order = array();
$data_order["person_name"] = "Person";
$data_order["active"] = "Active?";
$data_order["delete"] = ".";

$table = new rs_list($data_order, $recs);
$table->empty_message("--");
if (isset($change_row)) { $table->set_row_attr($change_row, "class", "hl_change"); }
$table->identify("", "table table-striped");

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

