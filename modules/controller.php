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

//====================================================================
// Remove TinyMCE Settings
//====================================================================
if (isset($_SESSION['moxiemanager.filesystem.local.wwwroot'])) {
	unset($_SESSION['moxiemanager.filesystem.local.wwwroot']);
}
if (isset($_SESSION['moxiemanager.filesystem.rootpath'])) {
	unset($_SESSION['moxiemanager.filesystem.rootpath']);
}

//====================================================================
// Validate Site ID if Given
//====================================================================
$site_id = false;
$valid_site = false;
if (is_numeric($segment_1) && $site_params = Sites::init_site_params($segment_1)) {
	extract($site_params);
	$site_id = $valid_site;
	define('SITE_ID', $site_id);
	$document_root = trim($document_root);
	$_SESSION['moxiemanager.filesystem.local.wwwroot'] = $document_root;
	$content_dir = trim($content_dir);
	if ($content_dir) {
		$_SESSION['moxiemanager.filesystem.rootpath'] = $content_dir;		
	}
	if ($document_root != '') { $document_root = realpath($document_root); }
	if ($content_dir != '') { $content_dir = realpath($content_dir); }
}

//====================================================================
// Main Module Controller
//====================================================================
if (isset($_SESSION['system_error'])) {
	$segment_1 = 'system_error';
}

//====================================================================
// Flow Control
//====================================================================
switch ($segment_1) {

	//---------------------------------------------------
	// System Error
	//---------------------------------------------------
	case 'system_error':
		$mod_title = 'Error!';
		$mod_icon_class = 'icon-warning-sign';
		add_error_message($_SESSION["system_error"]);
		unset($_SESSION['system_error']);
        break;
        
	//---------------------------------------------------
	// Change Password
	//---------------------------------------------------
	case 'change_pass':
		$mod_title = 'Change My Password';
		$mod_base_url .= 'change_pass/';
		$mod_base_url2 .= 'change_pass/';
		$mod_icon_class = 'fa fa-asterisk';
		include("home/change_pass/main.php");
        break;

	//---------------------------------------------------
	// Admin Modules
	//---------------------------------------------------
	case 'admin':
		if (isset($admin_status) && $admin_status > 0) {
			$mod_icon_class = 'icon-wrench';
			$mod_base_url .= 'admin/';
			$mod_base_url2 .= 'admin/';
			include("admin/controller.php");
		}
		else {
			include('sites/controller.php');
		}
		break;

	//---------------------------------------------------
	// API Modules
	//---------------------------------------------------
	case 'api':
		$mod_base_url .= 'api/';
		$mod_base_url2 .= 'api/';
		include('api/controller.php');
		break;

	//---------------------------------------------------
	//---------------------------------------------------
	// Site Modules
	//---------------------------------------------------
	//---------------------------------------------------
	default:

		//=====================================================================
		// Mod Image, Site View URL
		//=====================================================================
		$site_view_url = $mod_base_url;
		if (!empty($site_id)) {
			$site_view_url .= "{$site_id}/";
		}

		//=====================================================================
		// More Flow Control
		//=====================================================================
		if (!$site_id) {
			include('sites/controller.php');
		}
		else {
			if ($segment_2 != '') {
				$curr_asms = $this->get_mod_var('active_site_mods');
				$user_access = $this->get_mod_var('lwcms_user_access');

				if (isset($_SESSION['app_modules'][$segment_2]) && isset($curr_asms[$segment_2])) {
					$curr_module = $_SESSION['app_modules'][$segment_2];
					$mod_dir = $curr_module['mod_dir'];
					$mod_title = $curr_module['mod_desc'];
					$phrase = $curr_module['phrase'];
					$GLOBALS['phrase'] = $phrase;
					$mod_controller = dirname(__FILE__) . "/{$mod_dir}/controller.php";

					//=====================================================================
					// Access Level
					//=====================================================================
					if ($admin_status > 0) { $acc_lvl = 3; }
					else if (isset($user_access[$segment_2])) { $acc_lvl = $user_access[$segment_2]; }
					else { $acc_lvl = 0; }

					if (file_exists($mod_controller) && $acc_lvl) {
						if (!empty($curr_module['icon_class'])) { $mod_icon_class = $curr_module['icon_class']; }
						$mod_base_url .= "{$site_id}/{$phrase}/";
						$mod_base_url2 .= "{$site_id}/{$phrase}/";

						//=====================================================================
						// Add Site ID / Name to XML
						//=====================================================================
						$breadcrumbs[] = anchor("{$this->html_path}/{$site_id}/", html_escape($site_name));
						$breadcrumbs[] = anchor($mod_base_url, html_escape($curr_module['mod_desc']));

						//=====================================================================
						// Include Module Controller
						//=====================================================================
						include($mod_controller);
					}
					else {
						redirect($site_view_url);
					}
				}
				else {
					redirect($site_view_url);
				}
			}
			else {
				include('sites/controller.php');
			}
		}
		break;
}

//====================================================================
// Debug
//====================================================================
//$this->set_output_xml();

