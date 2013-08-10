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
$ssv->add_check("entry_title", "is_not_empty", "You must enter an entry title.");
$ssv->add_check("entry_author", "is_not_empty", "You must select an author.");
$ssv->add_check("cat_id", "is_not_empty", "You must select a category.");
//$ssv->add_check("stage", "is_not_empty", "You must select a stage.");
$ssv->add_check("entry_content", "is_not_empty", "You must enter entry content.");

if ($action == "update") {
	$ssv->add_check("pd_date", "is_not_empty", "You must enter a post date.");
	$ssv->add_check("pd_date", "is_date", "Post date must be a valid date.");
}

$ssv_status = $ssv->validate();

?>