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

//****************************************************************************
// Update #2
//**************************************************************************** 
$strsql = "select count(*) as count_recs from app_modules where phrase = 'static_content'";
$count = qdb_lookup($_SESSION["lwcms_ds"], $strsql, "count_recs");
if (!$count) {
	$sql_updates[2] = "INSERT INTO `app_modules` (`id` , `phrase` , `mod_desc` , `image` , `mod_dir` , `content_dir`) VALUES ( NULL , 'static_content', 'Content (Static)', 'img/icons/page_edit.png', 'static_content', 'static_content')";
}
else {
	$sql_updates[2] = "UPDATE `app_modules` SET `mod_desc` = 'Content (Static)' WHERE `app_modules`.`phrase` = 'static_content' LIMIT 1 ;";
}

