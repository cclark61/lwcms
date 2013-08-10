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
// Get Modules Arguments
//=================================================================
$get_mods_args = array(
	'segment_2' => $segment_2,
	'mod_base_url' => $mod_base_url,
	'mod_base_url2' => $mod_base_url2,
);

//=================================================================
//=================================================================
// Get Admin Modules Function
//=================================================================
//=================================================================
function get_admin_modules($args)
{
	extract($args);
	$icon_base_dir = ICON_BASE_DIR;
	$dirs = array();
	$list = scandir(dirname(__FILE__));
	foreach ($list as $item) {
		$full_dir = dirname(__FILE__) . '/' . $item;
		$dir_mod_info = "{$full_dir}/mod_info.php";
		if ($item == '.' || $item == '..' || !is_dir($full_dir) || !file_exists($dir_mod_info)) {
			continue;
		}
		unset($mod_title);
		unset($mod_image);
		include($dir_mod_info);

		if (isset($mod_title) && isset($mod_image)) {
			$dirs[$item] = array(
				'mod_title' => $mod_title,
				'mod_image' => $mod_image
			);
		}
	}

	return $dirs;
}

?>
