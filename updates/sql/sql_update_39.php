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
// Update #39
// Update Static Content Description
//**************************************************************************** 
$sql_updates[39] = "UPDATE `app_modules` SET `mod_desc` = 'Static Content ' WHERE `app_modules`.`phrase` = 'static_content' LIMIT 1 ;";

?>
