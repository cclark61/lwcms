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
// Update #10
// Drop site_seo_entries
//**************************************************************************** 
if (lwcms_db_table_exists('site_seo_entries')) {
	$sql_updates[10] = "DROP TABLE `site_seo_entries`;";
}

?>
