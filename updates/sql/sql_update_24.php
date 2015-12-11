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
// Update #24
// Alter site_entries, change content to MEDIUMTEXT
//****************************************************************************
$sql_updates[24] = "ALTER TABLE `site_entries` CHANGE `content` `content` MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ";

