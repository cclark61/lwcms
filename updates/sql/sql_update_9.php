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
// Update #9
// Drop site_module_options
//**************************************************************************** 
if (lwcms_db_table_exists('site_module_options')) {
	$sql_updates[9] = "DROP TABLE `site_module_options`;";
}

