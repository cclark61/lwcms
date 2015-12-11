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
// Update #23
// Alter content_versions, change raw_content to MEDIUMTEXT
//****************************************************************************
$sql_updates[23] = "ALTER TABLE `content_versions` CHANGE `raw_content` `raw_content` MEDIUMTEXT NULL DEFAULT NULL";

