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
	$this->add_js_file("content_edit.js");
}

//**************************************************************
// CodeMirror
//**************************************************************
if (!empty($codemirror_mode)) {
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

