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
// Update #47
// Alter site_entries, add version columns
//****************************************************************************
if (!lwcms_db_table_field_exists('site_blog_entries', 'version_dev')) {
	$sql_updates[47] = "
		ALTER TABLE `site_blog_entries` ADD `version_dev` INT NOT NULL DEFAULT '0',
		ADD `version_test` INT NOT NULL DEFAULT '0',
		ADD `version_live` INT NOT NULL DEFAULT '0'
	";
}

