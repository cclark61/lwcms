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

if ($_SESSION["userid"] == "admin" || SUPER_ADMIN) {
	$mod_title = "Set Administrative Users";
	$mod_image = image("{$icon_base_dir}/key.png", "[&raquo;]", array("title" => "Set Administrators", "class" => "gen_icon"));
}

