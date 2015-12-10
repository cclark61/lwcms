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

//**************************************************************
// Version
//**************************************************************
$this->add_xml('version', xml_escape($_SESSION['version']));

//**************************************************************
// Theme
//**************************************************************
$this->add_xml("theme", $this->theme);
$this->add_xml("theme_path", "{$this->html_path}/themes/{$this->theme}");

//**************************************************************
// Load Auxillary JavaScript if Necessary
//**************************************************************
include(__DIR__ . '/common/load-js.php');

//**************************************************************
// Module Title
//**************************************************************
if (empty($mod_title)) { $mod_title = "???"; }
$this->add_xml("mod_title", xml_escape($mod_title));

//**************************************************************
// Back Link
//**************************************************************
if (!empty($back_link)) { $this->add_xml("back_link", xml_escape($back_link)); }

//**************************************************************
// Module Images / Icon Classes
//**************************************************************
if (!empty($mod_icon_class)) { $this->add_xml("mod_icon_class", xml_escape($mod_icon_class)); }

//**************************************************************
// Links
//**************************************************************
if (!empty($top_mod_links)) { $this->add_xml("top_mod_links", xml_escape_array($top_mod_links)); }

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
if (!empty($_SESSION["site_footer"])) { $this->add_xml("site_footer", xml_escape($_SESSION["site_footer"])); }

//**************************************************************
// Layout Type
//**************************************************************
if (!empty($layout_type)) { $this->add_xml("layout_type", xml_escape($layout_type)); }

//**************************************************************
// Messages
//**************************************************************
$message_types = array(
	'error_message',
	'warn_message',
	'action_message',
	'gen_message',
	'page_message',
	'bottom_message',
	'timer_message'
);

foreach ($message_types as $msg_type) {
	if (!empty($$msg_type) || !empty($_SESSION[$msg_type])) {
		$formatted_messages = false;
		if (!empty($$msg_type) && !empty($_SESSION[$msg_type])) {
			$formatted_messages = format_page_messages($$msg_type, $_SESSION[$msg_type]);
			unset($_SESSION[$msg_type]);
		}
		else if (!empty($$msg_type)) {
			$formatted_messages = format_page_messages($$msg_type);
		}
		else if (!empty($_SESSION[$msg_type])) {
			$formatted_messages = format_page_messages($_SESSION[$msg_type]);
			unset($_SESSION[$msg_type]);
		}
		if ($formatted_messages) {
			$this->add_xml($msg_type, array2xml('messages', $formatted_messages));
		}
	}
}

//**************************************************************
//**************************************************************
// Format Page Messages function
//**************************************************************
//**************************************************************
function format_page_messages()
{
	$messages = array();
	$args = func_get_args();
	foreach ($args as $arg) {
		if (is_array($arg) && count($arg) > 0) {
			foreach ($arg as $key => $arg_msg) {
				$messages[] = xml_escape($arg_msg);
			}
		}
		else if ((string)$arg != '') {
			$messages[] = xml_escape($arg);
		}
	}

	return $messages;
}

