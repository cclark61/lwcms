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
// Update #29
// Alter site_entries, add 'metadata' column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'metadata')) {
	$sql_updates[29] = "ALTER TABLE `site_entries` ADD `metadata` TEXT NULL AFTER `content`";
}

?>
