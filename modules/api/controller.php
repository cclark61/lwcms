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

//--------------------------------------------------------
// Include Local Functions / Variables
//--------------------------------------------------------
if (file_exists('local.func.php')) { include('local.func.php'); }
if (file_exists('local.var.php')) { include('local.var.php'); }

//--------------------------------------------------------
// Set Page Type
//--------------------------------------------------------
$this->page_type = 'page_text';

//--------------------------------------------------------
// Flow Control
//--------------------------------------------------------
if (trim($segment_2)) {
	$controller = __DIR__ . "/{$segment_2}/controller.php";
	if (file_exists($controller)) {
		ob_start();
		include($controller);
		$return_content = trim(ob_get_clean());
		if ($return_content == '') {
			print '0:EMPTY';
			return false;
		}

		print $return_content;
		return true;
	}
	else {
		print '0:NOT FOUND';
		return false;
	}
}
else {
	print '0:INVALID';
	return false;
}

?>
