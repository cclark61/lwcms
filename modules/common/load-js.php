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

//**************************************************************
// TinyMCE
//**************************************************************
if (!empty($load_tinymce)) {
	$this->add_js_file("/bower_components/tinymce/tinymce.min.js");
	$mm_path = $this->file_path . '/bower_components/tinymce/plugins/moxiemanager';
	if (is_dir($mm_path)) {
		$this->add_js_file("content_edit.js");
	}
	else {
		$this->add_js_file("content_edit2.js");
	}
}

//**************************************************************
// CodeMirror
//**************************************************************
if (!empty($codemirror_mode)) {

	//========================================================
	// Default: Don't use Code Mirror
	//========================================================
	$use_code_mirror = false;

	//========================================================
	// Detect Mode
	//========================================================
	switch ($codemirror_mode) {

		case 'class.php':
		case 'inc.php':
		case 'php':
			$use_code_mirror = true;
			$cm_js_files = array(
				'/bower_components/codemirror/mode/clike/clike.js', 
				'/bower_components/codemirror/mode/xml/xml.js',
				'/bower_components/codemirror/mode/html/html.js',
				'/bower_components/codemirror/mode/css/css.js',
				'/bower_components/codemirror/mode/javascript/javascript.js',
				'/bower_components/codemirror/mode/php/php.js', 
				'codemirror/codemirror_php.js'
			);
			break;

		case 'js':
		case 'json':
			$use_code_mirror = true;
			$cm_js_files = array(
				'/bower_components/codemirror/mode/clike/clike.js',
				'/bower_components/codemirror/mode/javascript/javascript.js', 
				'codemirror/codemirror_js.js'
			);
			break;

		case 'css':
			$use_code_mirror = true;
			$cm_js_files = array(
				'/bower_components/codemirror/mode/css/css.js', 
				'codemirror/codemirror_css.js'
			);
			break;

		case 'xsl':
		case 'xml':
		case 'xhtml':
			$use_code_mirror = true;
			$cm_js_files = array(
				'/bower_components/codemirror/mode/xml/xml.js',
				'codemirror/codemirror_xml.js'
			);
			break;

	}

	//========================================================
	// Use Code Mirror?
	//========================================================
	if ($use_code_mirror) {
		$this->add_js_file('/bower_components/codemirror/lib/codemirror.js');
		$this->add_css_file('/bower_components/codemirror/lib/codemirror.css');
		$this->add_css_file('/bower_components/codemirror/theme/3024-day.css');

		foreach ($cm_js_files as $js_file) {
			$this->add_js_file($js_file);
		}
	}
}

