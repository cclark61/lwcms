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

//=========================================================================
// Module Settings
//=========================================================================
$mod_title = 'Authors';
$mod_icon_class = 'fa fa-user';

//=========================================================================
// Get all currently used authors
//=========================================================================

//-----------------------------------------------------
// From Blog Entries
//-----------------------------------------------------
$strsql = "select distinct(entry_author) from site_blog_entries where site_id = ?";
$used_blog_authors = qdb_exec('', $strsql, array('i', $site_id), 'entry_author:entry_author');

//-----------------------------------------------------
// From Site Entries
//-----------------------------------------------------
$strsql = "select distinct(entry_author) from site_entries where site_id = ?";
$used_content_authors = qdb_exec('', $strsql, array('i', $site_id), 'entry_author:entry_author');

