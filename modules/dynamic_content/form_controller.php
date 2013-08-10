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
// Add next actions for this module
//==================================================================
$next_action['folder_options'] = 'update_folder_opts';

//==================================================================
// Set ID if blank
//==================================================================
if (!isset($id)) { $id = ""; }

//==================================================================
// Create object
//==================================================================
if ($pull_from_db) {
	if ($action == 'folder_options' && $id == 0) {
		$strsql = 'select * from site_entries where site_id = ? and id = 0';
		$rec = qdb_first_row('', $strsql, array('i', SITE_ID));
		if (!$rec) {
			$entry_title = 'Top Level';
			$metadata = false;
		}
		else {
			$entry_title = $rec['entry_title'];
			$metadata = $rec['metadata'];
		}
	}
	else {
		$se = new site_entry();
		if ($action == "add_folder" || $action == "add_entry") {
			$se->no_load("parent");
			$se->no_load("node_path");
			$se->no_load('site_id');
		}
		$load_status = $se->load($id);
		if (!$load_status && substr($action, 0, 3) != 'add') {
			add_warn_message('Invalid Entry or Folder');
			include('main.php');
			return false;	
		}
		extract($se->export());
	}
}

//==================================================================
// Check if action exists
//==================================================================
if (isset($next_action[$action])) {

	//------------------------------------------
	// Back Link
	//------------------------------------------
	$back_link = $mod_base_url;

	//------------------------------------------
	// Flow Control
	//------------------------------------------
    switch ($action) {

    	case "add_folder":
    		$form_label = "Add a Folder";
    		include("frm_main.php");
    		break;

    	case "add_entry":
    		$form_label = "Add an Entry";
			$this->add_js_file("tinymce/js/tinymce/tinymce.min.js");
			$this->add_js_file("content_edit.js");
    		include("frm_main.php");
    		break;

		case "edit":
			$form_label = ($action == 'add_folder' || $entry_type == 1) ? ("Edit a Folder") : ("Edit an Entry");
			if ($entry_type == 2) {
				$this->add_js_file("tinymce/js/tinymce/tinymce.min.js");
				$this->add_js_file("content_edit.js");
			}
			include("frm_main.php");
			break;

		case "revisions":
			$content_type = 'dyn_cont';
			include("{$mod_common_dir}/content_versions/revisions.php");
			break;

		case "view_version":
			$this->page_type = 'page_text';
			$content_type = 'dyn_cont';
			include("{$mod_common_dir}/content_versions/view_version.php");
			break;

		case 'view':
		case "preview":
			if ($entry_type == 2) {
				print div(strong('Preview of: ') . em($entry_title), array("class" => "well"));
				$url = add_url_params($mod_base_url, array("action" => "iframe", "id" => $id));
				print xhe('iframe', 'Cannot display conntent.', array('src' => $url, 'width' => '100%', 'height' => '500'));
			}
			else { include('main.php'); }
			break;

		case "iframe":
			if ($entry_type == 2) {
				$this->page_type = 'page_text';
				if (trim($content) == '') {
					print em('There is no content for this entry.');
				}
				else { print $content; }
			}
			else { 'Cannot display a folder.'; }
			break;
			
		case "confirm_delete":
			if ($entry_type == 1) {
				$msg = "Are sure you want to delete the folder <em>{$entry_title}</em> and all of it's sub entries?";
			}
			else {
				$msg = "Are sure you want to delete the entry <em>{$entry_title}</em>?";
			}
			POP_TB::delete_form($this, array(
				'url' => $mod_base_url2,
				'message' => $msg,
				'hidden_vars' => array(
					'id' => $id,
					'prev_action' => $action,
					'action' => $next_action[$action],
					'node_path' => $node_path,
					'entry_type' => $entry_type
				),
				'form_label' => "Delete an Entry"
			));
			break;

    	case "folder_options":
    		$form_label = "Folder Options";
    		include("frm_folder_opts2.php");
    		break;

    }
}
else {
    include("main.php");
}

?>
