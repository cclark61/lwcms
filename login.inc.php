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
// Login Include File
//=========================================================================
//=========================================================================

//**************************************************************************
// Plugins
//**************************************************************************
load_plugin('qdba');
load_plugin('lwcms');

//**************************************************************************
// Default Data Source
//**************************************************************************
if (isset($_SESSION['lwcms_ds'])) {
	default_data_source($_SESSION['lwcms_ds']);

	//**************************************************************************
	// Force the Usage of the Improved MySQL Driver (mysqli)
	//**************************************************************************
	if (isset($_SESSION[$_SESSION['lwcms_ds']])) {
		$_SESSION[$_SESSION['lwcms_ds']]['type'] = 'mysqli';
	}
}

//**************************************************************************
// Are we using HTTPS?
//**************************************************************************
$_SESSION['https'] = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ? (1) : (0);
$_SESSION['protocol'] = ($_SESSION['https']) ? ('https') : ('http');

//**************************************************************************
// Set Plugin Folders
//**************************************************************************
set_plugin_folder(dirname(__FILE__) . '/plugins/dios');
set_plugin_folder(dirname(__FILE__) . '/plugins/daos');
set_plugin_folder(dirname(__FILE__) . '/vendor/cclark61/phpOpenPlugins');

//**************************************************************************
// Admin Status / Super Admin Status
//**************************************************************************
$strsql = "select * from users where userid = ?";
$cui = qdb_first_row('', $strsql, array('s', $_SESSION['userid']));
$_SESSION['lwcms_admin_status'] = (isset($cui['admin'])) ? ($cui['admin']) : (0);
$_SESSION['lwcms_super_admin_status'] = (isset($cui['super_admin'])) ? ($cui['super_admin']) : (0);
$_SESSION['super_admin'] = $_SESSION['lwcms_super_admin_status'];

//**************************************************************************
// Process System Updates
//**************************************************************************
$updates_file = dirname(__FILE__) . '/system_updates.inc.php';
if (file_exists($updates_file)) { include($updates_file); }

//**************************************************************************
// Version
//**************************************************************************
$_SESSION['version'] = file_get_contents('VERSION');

//**************************************************************************
// URL / Control Format
//**************************************************************************
if (isset($_SERVER['REDIRECT_URL'])) { $_SESSION['nav_xml_format'] = 'rewrite'; }
else { $_SESSION['nav_xml_format'] = 'long_url'; }

//**************************************************************************
// Theme
//**************************************************************************
if (empty($_SESSION['theme'])) { $_SESSION['theme'] = 'default'; }

//**************************************************************************
// Timezone
//**************************************************************************
if (empty($_SESSION['time_zone'])) { $_SESSION['time_zone'] = "America/New_York"; }

//**************************************************************************
// Server Side Validation Template
//**************************************************************************
$_SESSION['ssv_template'] = __DIR__ . '/templates/ssv_messages.xsl';

//**************************************************************************
//**************************************************************************
// After Login, redirect to HOME
//**************************************************************************
//**************************************************************************
//print_r(error_get_last());
if (!error_get_last()) {
	$tmp_path = $_SESSION['html_path'] . '/';
	header("Location: {$tmp_path}");
	exit;
}

