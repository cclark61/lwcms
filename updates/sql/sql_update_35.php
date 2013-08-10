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
// Update #35
// Drop site_events table
//**************************************************************************** 
if (lwcms_db_table_exists('site_events')) {
	$sql_updates[35] = "DROP TABLE site_events";
}

?>
