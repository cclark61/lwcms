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
// Update #13
// Drop Entry Stage from site_entries (dynamic content) table
//****************************************************************************
if (lwcms_db_table_field_exists('site_entries', 'entry_stage')) {
	$sql_updates[13] = "ALTER TABLE `site_entries` DROP `entry_stage`";
}

