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
// Update #33
// Drop site_navs_items table
//**************************************************************************** 
if (lwcms_db_table_exists('site_navs_items')) {
	$sql_updates[33] = "DROP TABLE site_navs_items";
}

