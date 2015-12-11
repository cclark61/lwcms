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
// Pull a list of Records
//==================================================================
$recs = get_content_versions($content_type, $id);

//==================================================================
// Sanitize Records
//==================================================================
format_records($recs, array(
	'create_user' => 'html_escape'
));

//==================================================================
// Format Records
//==================================================================
foreach ($recs as $key => &$rec) {

	//---------------------------------------------
	// Links / Action
	//---------------------------------------------
	$view_version_link = add_url_params($mod_base_url, array("action" => "view_version", "id" => $id, "version" => $rec['id']));
	$tmp_attrs = array(
		'content_link' => $view_version_link, 
		'class' => 'btn view_version', 
		'data-toggle' => 'modal', 
		'data-target' => "#revision_modal"
	);
	$rec["actions"] = xhe('a', $view_image, $tmp_attrs);

	//---------------------------------------------
	// Dates
	//---------------------------------------------
	$rec["create_date"] = ($rec['create_date'] != "") ? (mystamp_pretty($rec['create_date'])) : ("--");

	//---------------------------------------------------------
	// Publish Status
	//---------------------------------------------------------
	$disp_pub_status = ($version_live == $rec['id']) ? ('Published') : ('Draft');
	$pub_status_class = ($version_live == $rec['id']) ? ('label label-success') : ('label label-default');
	$rec["publish_status"] = span($disp_pub_status, array('class' => $pub_status_class));
}

//==================================================================
// Data Order
//==================================================================
$data_order = array();
$data_order["create_date"] = "Date";
$data_order["create_user"] = "User";
$data_order["publish_status"] = "Status";
$data_order["actions"] = "Actions";

//==================================================================
// Display Records
//==================================================================
$table = new rs_list($data_order, $recs);
$table->empty_message("--");
$table->identify("", "table table-striped");
$table->label('Revisions');
$table->set_col_attr("create_user", "class", "hidden-xs", false, true);

ob_start();
$table->render();
print div(ob_get_clean(), ['class' => 'table-responsive']);

//==================================================================
// Include Modal
//==================================================================
include(__DIR__ . '/version_modal.html');

