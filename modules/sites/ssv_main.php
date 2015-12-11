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

$ssv = new server_side_validation();
$ssv->add_check("site_name", "is_not_empty", "You must enter a site name.");
//$ssv->add_check("content_dir", "is_not_empty", "You must enter a site content directory.");
$ssv_status = $ssv->validate();

