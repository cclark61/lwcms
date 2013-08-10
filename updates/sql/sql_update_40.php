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
// Update #40
// Update Dynamic Content Description
//**************************************************************************** 
$sql_updates[40] = "UPDATE `app_modules` SET `mod_desc` = 'Publishable Content ' WHERE `app_modules`.`phrase` = 'dynamic_content' LIMIT 1 ;";

?>
