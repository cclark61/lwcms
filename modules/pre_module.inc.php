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

//=========================================================================
//=========================================================================
// Pre-module execution include file
//=========================================================================
//=========================================================================

//*************************************************************************
// Include OpenCore Pre-Module File
//*************************************************************************
include(OPENCORE_PATH . '/modules/pre_module.inc.php');

//**********************************************************
// Load Plugins
//**********************************************************
load_plugin("lwcms");

//**********************************************************
// Add-in CSS
//**********************************************************
$this->add_css_file('/themes/default/lwcms.css?' . $_SESSION['version']);

//**********************************************************
// Add-in Javascript
//**********************************************************
$this->add_js_file('/bower_components/jQuery.MultiFile/jQuery.MultiFile.min.js?' . $_SESSION['version']);
$this->add_js_file('main.js?' . $_SESSION['version']);

//**********************************************************
// Message Arrays
//**********************************************************
$error_message = array();
$warn_message = array();
$action_message = array();
$gen_message = array();

//**********************************************************
// Nav Arrays
//**********************************************************
$top_mod_links = array();
$breadcrumbs = array();

//**********************************************************
// Images
//**********************************************************
$add_image = css_icon('fa fa-plus');
$edit_image = css_icon('fa fa-pencil');
$open_image = css_icon('fa fa-folder-open-o');
$delete_image = css_icon('fa fa-times');
$view_image = css_icon('fa fa-eye');
$check_image = css_icon('fa fa-check');
$cat_image = css_icon('fa fa-list-ul');
$content_image = css_icon('fa fa-file-text-o');
$entries_image = css_icon('fa fa-list');
$file_image = css_icon('fa fa-file-text-o');
$folder_image = css_icon('fa fa-folder-o');
$cont_ent_image = $content_image;
$revisions_image = css_icon('fa fa-list-ol');
$open_folder_image = css_icon('fa fa-folder-open-o');
$add_file_image = $add_image;
$del_file_image = $delete_image;
$add_folder_image = $add_image;
$del_folder_image = $delete_image;
$upload_file_image = css_icon('fa fa-upload');
$image_image = css_icon('fa fa-image-o');

//**********************************************************
// Module URLs
//**********************************************************
$page_url = $this->page_url;
if ($_SESSION['nav_xml_format'] == 'long_url') { $page_url .= 'index.php/'; }
$mod_base_url = $page_url;
$mod_base_url2 = $page_url;
$mod_home_url = $mod_base_url;

//**********************************************************
// Base URL
//**********************************************************
$this->add_xml('base_url', xml_escape($page_url));

//**********************************************************
// Set Segments
//**********************************************************
$max_segments = 5;
$segments = array();
$current_path = '';
for ($i=0; $i <= $max_segments; $i++) {
	$key = $i+1;
	$segments[$key] = (isset($this->mod_params[$i])) ? ($this->mod_params[$i]) : (false);
	$segment_var = "segment_{$key}";
	$$segment_var = $segments[$key];
	define('SEGMENT_' . $key, $segments[$key]);
	$this->add_xml('segment_' . $key, $segments[$key]);
	
	if (!empty($segments[$key]) && $key != 1) {
		$current_path .= '/' . $segments[$key];
	}
}

//**********************************************************
// Admin Status
//**********************************************************
$admin_status = (isset($_SESSION["lwcms_admin_status"])) ? ($_SESSION["lwcms_admin_status"]) : (0);

//**********************************************************
// Action
//**********************************************************
if (!isset($action) && isset($this->action)) { $action = $this->action; }

//**********************************************************
// Access Levels
//**********************************************************
$access_levels = array();
$access_levels[] = "No Access";
$access_levels[] = "View / Edit";
$access_levels[] = "View / Edit / Add / Delete";
$access_levels[] = "View / Edit / Add / Delete / Manage"; 
$access_deny_msg = "You do not have access to perform the requested action!";

//**********************************************************
// Entry Stages
//**********************************************************
$stages_arr = array('Development', 'Test', 'Live');

//**********************************************************
// Default Layout Type
//**********************************************************
$layout_type = '1col';

//**********************************************************
// Set Action => Next Action Pairs
//**********************************************************
$next_action = array(
	"add" => "insert", 
	"add_folder" => "insert", 
	"add_entry" => "insert",
	"edit" => "update", 
	"confirm_delete" => "delete",
	'view' => 'view',
	'revisions' => 'revisions',
	'view_version' => 'view_version',
	"preview" => "preview",
	"iframe" => "iframe"
);

//**********************************************************
// Publish Statuses
//**********************************************************
$publish_statuses = array('Draft', 'Published');

//**********************************************************
// Modules Common Directory
//**********************************************************
$mod_common_dir = __DIR__ . '/common';

//**********************************************************
// Constants
//**********************************************************
define('SUPER_ADMIN', $_SESSION['super_admin']);
define('ADMIN_STATUS', $admin_status);
