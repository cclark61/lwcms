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
// Update #12
// Add cache_dynamic_content setting to sites
//**************************************************************************** 
if (!lwcms_db_table_field_exists('sites', 'cache_dynamic_content')) {
	$sql_updates[12] = "ALTER TABLE `sites` ADD `cache_dynamic_content` TINYINT NOT NULL DEFAULT '1'";
}

?>
