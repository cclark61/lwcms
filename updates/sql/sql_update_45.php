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
// Update #45
// Alter app_modules, add 'version' column
//****************************************************************************
if (!lwcms_db_table_field_exists('app_modules', 'version')) {
	$sql_updates[45] = "ALTER TABLE `app_modules` ADD `version` VARCHAR( 7 ) NULL DEFAULT NULL ";
}

?>
