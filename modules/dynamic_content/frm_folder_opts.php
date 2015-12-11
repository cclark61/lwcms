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

//******************************************************************
//******************************************************************
// Folder Options
//******************************************************************
//******************************************************************

//==================================================================
// Extract JSON Data from Meta Data Field
//==================================================================
$FOLDER_OPTS = (array)json_decode($metadata);
if (!is_array($FOLDER_OPTS)) { $FOLDER_OPTS = array(); }

//==================================================================
// Start Folder Entry Options Fieldset
//==================================================================
$form->start_fieldset('Folder Options');

//==================================================================
// Display Fields
//==================================================================
foreach ($folder_opt_fields as $field => $desc) {
	if (!isset($FOLDER_OPTS[$field])) { $FOLDER_OPTS[$field] = ''; }
	$ssa = new ssa("FOLDER_OPTS[{$field}]", $folder_opt_values);
	$ssa->selected_value($FOLDER_OPTS[$field]);
	$form->add_element(
		POP_TB::simple_control_group($desc, $ssa)
	);
}

//==================================================================
// End Folder Entry Options Fieldset
//==================================================================
$form->end_fieldset();

