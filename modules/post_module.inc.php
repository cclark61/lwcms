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
// Post-module execution include file
//=========================================================================
//=========================================================================

//=============================================================
// Include OpenCore Pre-Page Include File
//=============================================================
include(OPENCORE_PATH . '/modules/post_module.inc.php');

//**************************************************************
// Dates
//**************************************************************
$this->add_xml('curr_year', date('Y'));
$this->add_xml('curr_date', date('n/j/Y'));

//**************************************************************
// Load Auxillary JavaScript if Necessary
//**************************************************************
include(__DIR__ . '/common/load-js.php');

//**************************************************************
// Breadcrumbs
//**************************************************************
if (!empty($breadcrumbs)) { $this->add_xml("breadcrumbs", xml_escape_array($breadcrumbs)); }

//**************************************************************
// Admin Status
//**************************************************************
$this->add_xml("lwcms_admin_status", $admin_status);

//**************************************************************
// Site Title / Header / Footer
//**************************************************************
if (!empty($_SESSION["site_title"])) { $this->add_xml("site_title", xml_escape($_SESSION["site_title"])); }
if (!empty($_SESSION["site_header"])) { $this->add_xml("site_header", xml_escape($_SESSION["site_header"])); }
if (!empty($_SESSION['site_logo_url'])) { $this->add_xml('site_logo_url', xml_escape($_SESSION['site_logo_url'])); }

//**************************************************************
// Sites Menu
//**************************************************************
$sites_list = LWCMS::get_site_list();
if (!empty($sites_list)) {
	$site_menu = '';
	foreach ($sites_list as $site) {
		$link_attrs = [];
		if ($site['id'] == SEGMENT_1) {
			$link_attrs['class'] = 'active';
		}

		$site_menu .= li(
			anchor("/{$site['id']}/", css_icon('fa fa-globe') . ' ' . $site['site_name']), 
			$link_attrs
		);
	}
	$this->add_xml('site_menu', xml_escape($site_menu));
}

//**************************************************************
// Site Modules Menu
//**************************************************************

