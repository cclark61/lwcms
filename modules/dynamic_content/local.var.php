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
$mod_title = 'Publishable Content';
$mod_icon_class = 'fa fa-file-text-o';

//=========================================================================
// Mod Home URL
//=========================================================================
$mod_home_redir_url = $mod_base_url;
$mod_home_url = $mod_base_url;

//=========================================================================
// Set Module Table(s)
//=========================================================================
$mod_table = 'site_entries';
$mod_table2 = 'content_versions';

//=========================================================================
// Folder Option Values
//=========================================================================
$folder_opt_values = array(
	'show' => 'Show',
	'admin' => 'Admin Only',
	'hide' => 'Hide'
);
$folder_opt_bool_values = array(
	'1' => 'Yes',
	'0' => 'No'
);


