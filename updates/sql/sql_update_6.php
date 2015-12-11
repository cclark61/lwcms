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
// Update #6
// Add blog_id to site_blog_authors
//**************************************************************************** 
$sql_updates[6] = "ALTER TABLE `site_blog_authors` ADD `blog_id` INT NOT NULL DEFAULT '0' AFTER `site_id` ";

