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

//=================================================================
// Include Local Variables / Functions
//=================================================================
include('local.var.php');

//=================================================================
// Build Module List
//=================================================================
$admin_modules = get_admin_modules($get_mods_args);

//=================================================================
// Flow Control
//=================================================================
if ($segment_2 == '') {
	$mod_title = "Admin Control Panel";
	include("main.php");
}
else {
	if (isset($admin_modules[$segment_2])) {
		$mod_path = dirname(__FILE__) . "/{$segment_2}";
		$breadcrumbs[] = anchor($mod_base_url2, "Admin");
		$mod_base_url2 = $mod_base_url = "{$mod_base_url}{$segment_2}/";
		include("{$mod_path}/mod_info.php");
		include("{$mod_path}/controller.php");
	}
}


?>
