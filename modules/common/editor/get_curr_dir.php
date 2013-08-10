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

//===============================================================
// Check for Current Directory in URL
//===============================================================
$url_dir_stub = $segment_3;
$set_to_dr = false;
if (!$url_dir_stub) {
	$set_to_dr = true;
	$curr_dir = $base_dir;
}
else {
	$url_dir_stub = base64_decode($url_dir_stub);
}

if (!$set_to_dr) {
	$curr_dir = realpath("{$base_dir}/{$url_dir_stub}");
	if (!is_dir($curr_dir)) {
		$set_to_dr = true;
		$curr_dir = $base_dir;		
	}
	else if (strpos($curr_dir, $base_dir) === false) {
		$set_to_dr = true;
		$curr_dir = $base_dir;
	}
}

$disp_curr_dir = str_replace($base_dir, '', $curr_dir);
$curr_path = array(anchor($mod_base_url, $base_display));
if ($disp_curr_dir) {
	$url_parts = explode('/', $disp_curr_dir);
	if ($url_parts) {
		$tmp_base = '';
		foreach ($url_parts as $part) {
			if ($part == '') { continue; }
			$tmp_base .= ($tmp_base == '') ? ($part) : ('/' . $part);
			$curr_path[] = anchor($mod_base_url . base64_encode($tmp_base) . '/', $part);
		}
	}
}
$this->add_xml('current_path', xml_escape_array($curr_path));

//===============================================================
// Pull File Listing for Current Directory
//===============================================================
$dir_files = scandir($curr_dir);

//===============================================================
// Update Module Base URL
//===============================================================
if ($disp_curr_dir) {
	$mod_base_url .= base64_encode($disp_curr_dir) . '/';
	$mod_base_url2 .= base64_encode($disp_curr_dir) . '/';
}

//===============================================================
// Return Success
//===============================================================
return true;

?>
