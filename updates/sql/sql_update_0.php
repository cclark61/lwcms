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
// Update #0
//**************************************************************************** 
$sql_updates[0] = "
	UPDATE `app_modules` 
	SET `mod_desc` = 'Content (Dynamic)', `phrase` = 'dynamic_content', mod_dir = 'dynamic_content', content_dir = 'dynamic_content' 
	WHERE `app_modules`.`phrase` = 'content' LIMIT 1 ;";
	
