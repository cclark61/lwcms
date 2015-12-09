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

//**********************************************************
// Load Plugins
//**********************************************************
load_plugin("ssv");
load_plugin("xhtml_gen");
load_plugin("date_time");
load_plugin("lwcms");
load_plugin("POP_bootstrap3");
load_plugin('POP_format_content');

//**********************************************************
// Add-in CSS
//**********************************************************
$this->add_css_file('/bower_components/bootstrap/dist/css/bootstrap.min.css?') . $_SESSION['version'];
$this->add_css_file('/bower_components/fontawesome/css/font-awesome.min.css?' . $_SESSION['version']);
$this->add_css_file('/bower_components/jquery-ui/themes/ui-lightness/jquery-ui.min.css?' . $_SESSION['version']);
$this->add_css_file('/bower_components/AppJack/appjack.css?' . $_SESSION['version']);
$this->add_css_file('/themes/default/lwcms.css?' . $_SESSION['version']);

//**********************************************************
// Add-in Javascript
//**********************************************************
$this->add_js_file('/SwellCore/javascript/stay_standalone.js?'. $_SESSION['version']);
$this->add_js_file('/bower_components/bootstrap/dist/js/bootstrap.min.js?' . $_SESSION['version']);
$this->add_js_file('/bower_components/jquery/dist/jquery.min.js?' . $_SESSION['version']);
$this->add_js_file('/bower_components/jquery-ui/jquery-ui.min.js?' . $_SESSION['version']);
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
$img_base_dir = "{$this->html_path}/img";
define('IMG_BASE_DIR', $img_base_dir);
$icon_base_dir = "{$this->html_path}/img/icons";
define('ICON_BASE_DIR', $icon_base_dir);
$add_image = css_icon('fa fa-plus');
$edit_image = image("{$icon_base_dir}/edit.png", '[edit]', array('title' => 'Edit', 'class' => 'gen_icon'));
$open_image = image("{$icon_base_dir}/folder_go.png", '[open]', array('title' => 'Open', 'class' => 'gen_icon'));
$delete_image = css_icon('fa fa-times');
$view_image = css_icon('fa fa-eye');
$check_image = image("{$icon_base_dir}/tick.png", '[x]', array('title' => 'Complete', 'class' => 'gen_icon'));
$cat_image = image("{$icon_base_dir}/categories.png", '[!]', array('title' => 'List', 'class' => 'gen_icon'));
$content_image = image("{$icon_base_dir}/page_edit.png", '[!]', array('title' => 'Content', 'class' => 'gen_icon'));
$entries_image = image("{$icon_base_dir}/categories.png", '[!]', array('title' => 'Entries', 'class' => 'gen_icon'));
$folder_image = image("{$icon_base_dir}/folder.png", '[!]', array('title' => 'Folder', 'class' => 'gen_icon'));
$cont_ent_image = image("{$icon_base_dir}/page.png", '[!]', array('title' => 'Entry', 'class' => 'gen_icon'));
$revisions_image = image("{$icon_base_dir}/text_list_numbers.png", '[!]', array('title' => 'Revisions', 'class' => 'gen_icon'));

//**********************************************************
// Code Mirror Off by Default
//**********************************************************
$codemirror_mode = false;

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
define('ADMIN_STATUS', $admin_status);

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
// Constants
//**********************************************************
define('SUPER_ADMIN', $_SESSION['super_admin']);
define('BASE_URL', $page_url);
define('DEFAULT_TIMESTAMP', 'n/j/Y g:i a');

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
define('MOD_COMMON_DIR', $mod_common_dir);


