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
// Update #46
// 1. Remove publish_status column from site_entries table
// 2. Remove publish_status column from site_blog_entries table
//****************************************************************************
$sql_updates[46] = array();
if (lwcms_db_table_field_exists('site_entries', 'publish_status')) {
	$sql_updates[46][] = "ALTER TABLE `site_entries` DROP `publish_status`";
}
if (lwcms_db_table_field_exists('site_blog_entries', 'publish_status')) {
	$sql_updates[46][] = "ALTER TABLE `site_blog_entries` DROP `publish_status`";
}
if (!lwcms_db_table_field_exists('site_entries', 'active')) {
	$sql_updates[46][] = "ALTER TABLE `site_entries` ADD `active` TINYINT( 1 ) NOT NULL DEFAULT '1'";
}

