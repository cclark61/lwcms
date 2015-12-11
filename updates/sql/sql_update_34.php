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
// Update #34
// Drop site_news_posts table
//**************************************************************************** 
if (lwcms_db_table_exists('site_news_posts')) {
	$sql_updates[34] = "DROP TABLE site_news_posts";
}

