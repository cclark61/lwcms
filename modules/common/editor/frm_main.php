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

//===============================================================
// Create Form
//===============================================================
$form = new form_too($mod_base_url2);
$this->clear_mod_var("form_key");
$this->set_mod_var("form_key", $form->use_key());
$form->label($form_label);
$form->attr('.', 'form-horizontal');

//===============================================================
// Common Hidden Variables
//===============================================================
$form->add_hidden("action", $next_action[$action]);

//***********************************************
// Edit a File
//***********************************************
if ($this->action == "edit") {
	$file_content = file_get_contents($file_path);

	//==================================================================
	// File Path / File
	//==================================================================
	$form->add_hidden("disp_file_path", $disp_file_path);
	$form->add_hidden("file", base64_encode($file));

	//==================================================================
	// File Name
	//==================================================================
	$form->add_hidden("file_name", $file_name);
	$form->add_element(
		POP_TB::simple_control_group(false, array(
			div($disp_file_path, array('class' => 'hidden-xs')),
			div($file_name, array('class' => 'hidden-lg hidden-md hidden-sm'))
		), 'div', ['class' => 'well well-sm'])
	);

	//==================================================================
	// New File Name
	//==================================================================
	if (!isset($new_file_name)) { $new_file_name = $file_name; }
	if (!isset($rename_file)) { $rename_file = 0; }
	$chk_rename_file = new checkbox('rename_file', 1, $rename_file);
	$chk_rename_file->attr('id', 'rename_file');
	$txt_new_file_name = new textbox("new_file_name", $new_file_name, 30);
	if (!$rename_file) {
		$txt_new_file_name->attr('style', 'display: none;');
	}
	$form->add_element(
		POP_TB::simple_control_group("Rename File", array($chk_rename_file, $txt_new_file_name))
	);

	//==================================================================
	// File Contents
	//==================================================================
	$file_content = strip_cdata_tags($file_content);
	$textarea = new textarea("file_content", $file_content, 80, 30);
	$textarea->set_attribute('id', 'codemirror_editor');
	$textarea->attr('.', 'mceEditor');
	$textarea->set_attribute('style', 'width: 100%;');

	$form->add_element(
		POP_TB::simple_control_group(false, $textarea)
	);
}
//***********************************************
// Add a File
//***********************************************
else if ($this->action == "add") {
	if ($pull_from_db) {
		$file_content = "";
		$file_name = "";
	}

	//==================================================================
	// File Path
	//==================================================================
	$form->add_hidden("disp_file_path", $disp_file_path);

	//==================================================================
	// File Name
	//==================================================================
	$form->add_element(
		POP_TB::simple_control_group("File Name", new textbox("file_name", $file_name, 30))
	);

	//==================================================================
	// File Content
	//==================================================================
	$ta_file_content = new textarea("file_content", $file_content, 80, 30);
	$ta_file_content->attr('class', 'editable-input');
	$form->add_element(
		POP_TB::simple_control_group("Content", $ta_file_content)
	);

}
//***********************************************
// Add a Folder
//***********************************************
else if ($this->action == "add_dir") {
	if ($pull_from_db) {
		$folder_name = "";
	}

	//==================================================================
	// File Path
	//==================================================================
	$form->add_hidden("disp_file_path", $disp_file_path);

	//==================================================================
	// Folder Name
	//==================================================================
	$form->add_element(
		POP_TB::simple_control_group("Folder Name", new textbox("folder_name", $folder_name, 30))
	);
}
//***********************************************
// Upload a File
//***********************************************
else if ($this->action == "upload_file") {

	$form->set_attribute("enctype", "multipart/form-data");

	//==================================================================
	// File Path
	//==================================================================
	$form->add_hidden("disp_file_path", $disp_file_path);

	//==================================================================
	// Upload File
	//==================================================================
	$datafile = new file_upload("datafile[]");
	$datafile->set_attribute("class", "multi");
	$form->add_element(
		POP_TB::simple_control_group("File to Upload", $datafile)
	);

}

//==================================================================
// Save Button
//==================================================================
$form->add_element(POP_TB::save_button());

//===============================================================
// Render Form
//===============================================================
$form->render();

