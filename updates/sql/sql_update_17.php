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
// Update #17
// Add index_content column to site_entries
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'index_content')) {
	$sql_updates[17] = "ALTER TABLE `site_entries` ADD `index_content` TINYINT NOT NULL DEFAULT '1'";
}

?>
