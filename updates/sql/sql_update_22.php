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
// Update #22
// Alter site_entries, add version columns
//****************************************************************************
if (!lwcms_db_table_field_exists('site_entries', 'version_dev')) {
	$sql_updates[22] = "
		ALTER TABLE `site_entries` ADD `version_dev` INT NOT NULL DEFAULT '0',
		ADD `version_test` INT NOT NULL DEFAULT '0',
		ADD `version_live` INT NOT NULL DEFAULT '0'
	";
}

