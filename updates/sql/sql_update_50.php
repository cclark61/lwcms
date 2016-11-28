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
// Update #50
// Alter site_blog_entries, add meta data column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_blog_entries', 'metadata')) {
	$sql_updates[50] = "ALTER TABLE `site_blog_entries` ADD `metadata` TEXT NULL DEFAULT NULL AFTER `entry_content`";
}
