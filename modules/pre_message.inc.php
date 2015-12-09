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
// Pre Message Page execution include file
//=========================================================================
//=========================================================================

//**************************************************************
// Site Message Title / Header / Footer
//**************************************************************
if (!empty($_SESSION['site_title'])) { $this->add_xml('site_title', xml_escape($_SESSION['site_title'])); }
if (!empty($_SESSION['msg_header'])) { $this->add_xml('msg_header', xml_escape($_SESSION['msg_header'])); }
if (!empty($_SESSION['msg_logo_url'])) { $this->add_xml('msg_logo_url', xml_escape($_SESSION['msg_logo_url'])); }
if (!empty($_SESSION['msg_footer'])) { $this->add_xml('msg_footer', xml_escape($_SESSION['msg_footer'])); }

//**************************************************************
// Version
//**************************************************************
$_SESSION['version'] = file_get_contents('VERSION');
$this->add_xml('version', xml_escape($_SESSION['version']));

//**************************************************************
// Theme
//**************************************************************
if (empty($this->theme)) { $this->theme = 'default'; }
$this->add_xml("theme", $this->theme);
$this->add_xml("theme_path", "{$this->html_path}/themes/{$this->theme}");

//**************************************************************
// Timezone
//**************************************************************
if (empty($config_arr['time_zone'])) {
	$config_arr['time_zone'] = "America/New_York";
}

//**************************************************************
// Current Year
//**************************************************************
$this->add_xml('curr_year', date('Y'));

