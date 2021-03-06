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
// Update #15
// Drop Publish Path from site_entries (dynamic content) table
//****************************************************************************
if (lwcms_db_table_field_exists('site_entries', 'publish_path')) {
	$sql_updates[15] = "ALTER TABLE `site_entries` DROP `publish_path`";
}

