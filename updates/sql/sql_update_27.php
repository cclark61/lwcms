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
// Update #27
// Alter site_blog_entries, add 'stage' column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_blog_entries', 'stage')) {
	$sql_updates[27] = "ALTER TABLE `site_blog_entries` ADD `stage` TINYINT NOT NULL DEFAULT '2'";
}

?>
