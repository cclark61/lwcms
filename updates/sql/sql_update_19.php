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
// Updates #19
// Drop published column from site_entries
//****************************************************************************
if (lwcms_db_table_field_exists('site_entries', 'published')) {
	$sql_updates[19] = "ALTER TABLE `site_entries` DROP `published`";
}

?>
