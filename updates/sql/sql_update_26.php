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
// Update #26
// Add Authors module entry into app_modules
//****************************************************************************
$strsql = "select count(*) as count from app_modules where phrase = 'authors'";
$count = qdb_lookup($_SESSION["lwcms_ds"], $strsql, 'count');
$count += 0;

if (!$count) {
	$sql_updates[26] = "
		INSERT INTO `app_modules` 
		(
			`phrase` ,
			`mod_desc` ,
			`image` ,
			`mod_dir` ,
			`content_dir`
		)
		VALUES 
		(
			'authors', 'Authors', 'img/icons/user_edit.png', 'authors', ''
		)
	";
}

