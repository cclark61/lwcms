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
// Update #28
// Alter site_entries, add 'entry_author' column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'entry_author')) {
	$sql_updates[28] = "ALTER TABLE `site_entries` ADD `entry_author` SMALLINT NOT NULL DEFAULT '0' AFTER `post_date` ";
}

