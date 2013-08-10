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
// Theme
//**************************************************************
$this->add_xml("theme", $this->theme);
$this->add_xml("theme_path", "{$this->html_path}/themes/{$this->theme}");

//**************************************************************
// JQuery UI
//**************************************************************
if (isset($jquery_ui) && $jquery_ui === true) {
	$this->add_js_file('jquery-ui-1.10.0.custom.min.js');
	$this->add_css_file(
		array(
			'href' => '/themes/common/jquery-ui/ui-lightness/jquery-ui-1.10.0.custom.css',
			'type' => 'text/css',
			'rel' => 'stylesheet',
			'media' => 'all'
		)
	);
}

//**************************************************************
// CodeMirror
//**************************************************************
if ($codemirror_mode) {
	$use_code_mirror = false;

	switch ($codemirror_mode) {
		case 'class.php':
		case 'inc.php':
		case 'php':
			$use_code_mirror = true;
			$cm_js_files = array(
				'codemirror/mode/clike/clike.js', 
				'codemirror/mode/php/php.js', 
				'codemirror_php.js'
			);
			break;

		case 'js':
			$use_code_mirror = true;
			$cm_js_files = array(
				'codemirror/mode/clike/clike.js',
				'codemirror/mode/javascript/javascript.js', 
				'codemirror_js.js'
			);
			break;

		case 'css':
			$use_code_mirror = true;
			$cm_js_files = array(
				'codemirror/mode/css/css.js', 
				'codemirror_css.js'
			);
			break;

		case 'xsl':
		case 'xml':
		case 'xhtml':
			$use_code_mirror = true;
			$cm_js_files = array(
				'codemirror/mode/xml/xml.js',
				'codemirror_xml.js'
			);
			break;

	}

	if ($use_code_mirror) {
		$this->add_js_file('codemirror/lib/codemirror.js');
		$this->add_css_file(
			array(
				'href' => '/javascript/codemirror/lib/codemirror.css',
				'media' => 'all',
				'rel' => 'stylesheet',
				'type' => 'text/css'
			)
		);
		$this->add_css_file(
			array(
				'href' => '/javascript/codemirror/theme/default.css',
				'media' => 'all',
				'rel' => 'stylesheet',
				'type' => 'text/css'
			)
		);

		foreach ($cm_js_files as $js_file) {
			$this->add_js_file($js_file);
		}
	}
}

//**************************************************************
// Module Title
//**************************************************************
if (!isset($mod_title)) { $mod_title = "???"; }
$this->add_xml("mod_title", xml_escape($mod_title));

//**************************************************************
// Back Link
//**************************************************************
if (isset($back_link)) { $this->add_xml("back_link", xml_escape($back_link)); }

//**************************************************************
// Module Images / Icon Classes
//**************************************************************
if (isset($mod_icon_class)) { $this->add_xml("mod_icon_class", xml_escape($mod_icon_class)); }
//if (isset($mod_icon_class1)) { $this->add_xml("mod_icon_class1", xml_escape($mod_icon_class1)); }
//if (isset($mod_icon_class2)) { $this->add_xml("mod_icon_class2", xml_escape($mod_icon_class2)); }
//if (isset($mod_icon_class3)) { $this->add_xml("mod_icon_class3", xml_escape($mod_icon_class3)); }

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
// Change Password / Help Page Functionality
//**************************************************************
$this->add_xml("change_password", $change_password);
$this->add_xml("help_page", $help_page);

//**************************************************************
// Site Title / Header / Footer
//**************************************************************
if (isset($_SESSION["site_title"])) { $this->add_xml("site_title", xml_escape($_SESSION["site_title"])); }
if (isset($_SESSION["site_header"])) { $this->add_xml("site_header", xml_escape($_SESSION["site_header"])); }
if (isset($_SESSION["site_footer"])) { $this->add_xml("site_footer", xml_escape($_SESSION["site_footer"])); }

//**************************************************************
// Layout Type
//**************************************************************
if (isset($layout_type)) { $this->add_xml("layout_type", xml_escape($layout_type)); }

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

?>
