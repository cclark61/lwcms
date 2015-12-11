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

//=============================================================
// Include OpenCore Pre-Page Include File
//=============================================================
include(OPENCORE_PATH . '/modules/pre_message.inc.php');

//**************************************************************
// Site Message Title / Header / Footer
//**************************************************************
if (!empty($_SESSION['site_title'])) { $this->add_xml('site_title', xml_escape($_SESSION['site_title'])); }
if (!empty($_SESSION['msg_header'])) { $this->add_xml('msg_header', xml_escape($_SESSION['msg_header'])); }
if (!empty($_SESSION['msg_logo_url'])) { $this->add_xml('msg_logo_url', xml_escape($_SESSION['msg_logo_url'])); }

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

