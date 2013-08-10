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

switch ($this->action) {

	case "edit":
		$breadcrumbs[] = anchor($mod_base_url2, "Access Control (by Site)");
		include("form.php");
		break;

	case "update":
		include("update.php");
		break;
                
	default:
		include("main.php");
		break;
}

?>
