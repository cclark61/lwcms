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
// Update #41
// Add "Super Admin" column to users table
//**************************************************************************** 
$sql_updates[41] = "ALTER TABLE `users` ADD `super_admin` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `admin`";

