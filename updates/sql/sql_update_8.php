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
// Update #8
// Drop app_module_options
//**************************************************************************** 
if (lwcms_db_table_exists('app_module_options')) {
	$sql_updates[8] = "DROP TABLE `app_module_options`;";
}

?>
