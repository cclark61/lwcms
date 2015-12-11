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
// Update #30
// Alter site_entries, add 'cat_id' column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'cat_id')) {
	$sql_updates[30] = "ALTER TABLE `site_entries` ADD `cat_id` SMALLINT NOT NULL DEFAULT '0' AFTER `post_date`";
}

