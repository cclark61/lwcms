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
// Update #25
// Alter site_entries, add post_date column
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'post_date')) {
	$sql_updates[25] = "ALTER TABLE `site_entries` ADD `post_date` TIMESTAMP NULL AFTER `mod_date` ";
}

?>
