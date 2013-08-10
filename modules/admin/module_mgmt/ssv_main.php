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

if (!isset($_FILES["datafile"]) || $_FILES["datafile"]["name"] == "") {
	$ssv->add_check("0==1", "custom", "You must select a module ZIP file to upload.");
}
else {
	$ssv->add_check("1==1", "custom", "Pass");
}

$ssv_status = $ssv->validate();

?>