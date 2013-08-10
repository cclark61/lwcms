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

//***************************************************
// Get all currently used content categories
//***************************************************
$strsql = "select distinct(cat_id) from site_entries where site_id = ?";
$used_content_cats = qdb_exec('', $strsql, array('i', $site_id), 'cat_id:cat_id');


?>