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

//***************************************************************************
// LWCMS Class
//***************************************************************************
class LWCMS
{

	//=======================================================================
	//=======================================================================
	// Get Admin Modules Function
	//=======================================================================
	//=======================================================================
	public static function get_modules($args)
	{
		extract($args);
		if (empty($base_dir)) { return false; }
		$dirs = array();
		$list = scandir($base_dir);
		foreach ($list as $item) {
			$full_dir = $base_dir . '/' . $item;
			$dir_mod_info = "{$full_dir}/local.var.php";
			if ($item == '.' || $item == '..' || !is_dir($full_dir) || !file_exists($dir_mod_info)) {
				continue;
			}
			unset($mod_title);
			unset($mod_icon_class);
			include($dir_mod_info);
	
			if (isset($mod_title) && isset($mod_icon_class)) {
				$dirs[$item] = array(
					'mod_title' => $mod_title,
					'mod_icon_class' => $mod_icon_class
				);
			}
		}
	
		return $dirs;
	}

	//=======================================================================
	//=======================================================================
	// Get a List of Sites for Current User
	//=======================================================================
	//=======================================================================
	public static function get_site_list()
	{
		if (ADMIN_STATUS) {
			$strsql = 'select * from sites order by site_name';
			return qdb_list('', $strsql); // Ok
		}

		return lwcms_get_site_access();
	}

}

