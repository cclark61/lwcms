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
// Create Form
//==================================================================
$form = new form_too($mod_base_url2);
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->label($form_label);
$form->attr('.', 'form-horizontal');

//==================================================================
// Hidden Variables
//==================================================================
$form->add_hidden("prev_action", $action);
$form->add_hidden("action", $next_action[$action]);
$form->add_hidden("id", $id);

//==================================================================
// Extract JSON Data from Meta Data Field
//==================================================================
$FOLDER_OPTS = (array)json_decode($metadata);
if (!is_array($FOLDER_OPTS)) { $FOLDER_OPTS = array(); }

//==================================================================
// Folder Name
//==================================================================
$form->add_element(
	POP_TB::simple_control_group("Folder Name", span($entry_title, array('class' => 'control-label')))
);
		
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
// Save Buttons
//==================================================================
$form->add_element(POP_TB::save_button());

//==================================================================
// Render Form
//==================================================================
$form->render();

?>
