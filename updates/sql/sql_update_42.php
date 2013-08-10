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
// Update #42
// Lengthen password column in users table to accomodate hashed passwords
//**************************************************************************** 
$sql_updates[42] = "ALTER TABLE `users` CHANGE `password` `password` VARCHAR( 50 ) NOT NULL ";

?>
