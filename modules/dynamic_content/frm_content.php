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

//==================================================================
// Start Content Fieldset
//==================================================================
$form->start_fieldset('Content');

//==================================================================
// Content
//==================================================================
$ta_content = new textarea("content", strip_cdata_tags($content), 70, 30);
$ta_content->attr('.', 'mceEditor');
$form->add_element(
	POP_TB::simple_control_group(false, $ta_content)
);

//==================================================================
// End Content Fieldset
//==================================================================
$form->end_fieldset();


?>
