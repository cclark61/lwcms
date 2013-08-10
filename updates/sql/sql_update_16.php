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
// Update #16
// Add url_tag column to site_entries
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'url_tag')) {
	$sql_updates[16] = "ALTER TABLE `site_entries` ADD `url_tag` VARCHAR( 30 ) NULL";
} 

?>
