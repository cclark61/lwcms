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
//=========================================================================
// Pre-page execution include file
//=========================================================================
//=========================================================================

load_plugin("qdba");
load_plugin("dio");
load_plugin("content_gen");

// Check that default Data Source is set in session
if (!isset($_SESSION['lwcms_ds'])) {
	$_SESSION['system_error'] = 'Default data source is not set! This will prevent you from using this application!';
}

?>
