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

//====================================================================
// Mod Home URL
//====================================================================
$mod_home_redir_url = $mod_base_url;
$mod_home_url = $mod_base_url;

//====================================================================
// Load Object Plugin(s)
//====================================================================
load_plugin("site_entry");

//====================================================================
// Set Module Table(s)
//====================================================================
$mod_table = 'site_entries';
$mod_table2 = 'content_versions';

//====================================================================
// Folder Option Values
//====================================================================
$folder_opt_values = array(
	'show' => 'Show',
	'admin' => 'Admin Only',
	'hide' => 'Hide'
);

//====================================================================
// Folder Option Fields
//====================================================================
$folder_opt_fields = array(
	'entry_desc' => 'Description',
	'url_tag' => 'URL Tag/Key',
	'metadata' => 'Custom Data',
	'entry_author' => 'Author',
	'category' => 'Category',
	'post_date' => 'Post Date',
	'active' => 'Active',
	'content' => 'Content Area'
);

?>
