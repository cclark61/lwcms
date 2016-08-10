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
$form->start_fieldset('Entry Fields');

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

//==================================================================
// Start Folder Boolean Options Fieldset
//==================================================================
$form->start_fieldset('Folder Settings');

//==================================================================
// Display Fields
//==================================================================
foreach ($folder_opt_settings as $field => $field_settings) {

	//--------------------------------------------------------------
	// Field Setting Values
	//--------------------------------------------------------------
	$type = (isset($field_settings['type'])) ? ($field_settings['type']) : ('text');
	$default = (isset($field_settings['default'])) ? ($field_settings['default']) : (false);
	$title = (isset($field_settings['title'])) ? ($field_settings['title']) : (false);
	$field_name = "FOLDER_OPTS[{$field}]";

	//--------------------------------------------------------------
	// Current Value
	//--------------------------------------------------------------
	if (!isset($FOLDER_OPTS[$field])) { $FOLDER_OPTS[$field] = $default; }

	//--------------------------------------------------------------
	// Boolean Type
	//--------------------------------------------------------------
	if ($type == 'bool') {
		$form_field = new ssa($field_name, $folder_opt_bool_values);
		$form_field->selected_value($FOLDER_OPTS[$field]);
	}
	//--------------------------------------------------------------
	// Text Type
	//--------------------------------------------------------------
	else if ($type == 'text') {
		$form_field = new textbox($field_name, $FOLDER_OPTS[$field], 30);
	}

	//--------------------------------------------------------------
	// Create Form Element
	//--------------------------------------------------------------
	$form->add_element(
		POP_TB::simple_control_group($title, $form_field)
	);
}

//==================================================================
// End Folder Entry Options Fieldset
//==================================================================
$form->end_fieldset();

