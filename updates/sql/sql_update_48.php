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
// Update #48
// Update Modules to use font based icons
//**************************************************************************** 
$sql_updates[48] = array();
$sql_updates[48][] = "UPDATE `app_modules` SET `image` = 'fa fa-file-text-o' WHERE `app_modules`.`phrase` = 'dynamic_content' LIMIT 1;";
$sql_updates[48][] = "UPDATE `app_modules` SET `image` = 'fa fa-pencil-square-o' WHERE `app_modules`.`phrase` = 'blogs' LIMIT 1;";
$sql_updates[48][] = "UPDATE `app_modules` SET `image` = 'fa fa-code' WHERE `app_modules`.`phrase` = 'code_editor' LIMIT 1;";
$sql_updates[48][] = "UPDATE `app_modules` SET `image` = 'fa fa-file-text-o' WHERE `app_modules`.`phrase` = 'static_content' LIMIT 1;";
$sql_updates[48][] = "UPDATE `app_modules` SET `image` = 'fa fa-user' WHERE `app_modules`.`phrase` = 'authors' LIMIT 1;";

