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
// Update #32
// Drop site_navs table
//**************************************************************************** 
if (lwcms_db_table_exists('site_navs')) {
	$sql_updates[32] = "DROP TABLE site_navs";
}

?>
