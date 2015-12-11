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

//*******************************************************************
// Top Module Links
//*******************************************************************
$menu_links = array();
$menu_links["class"] = "page_links_list";

foreach ($admin_modules as $am_key => $am) {
	$menu_links["links"][] = array(
		"link" => "{$mod_base_url}{$am_key}/", 
		"desc" => $am['mod_title'], 
		"image" => xml_escape(css_icon($am['mod_icon_class']))
	);
}

//*******************************************************************
// Transform Data
//*******************************************************************
$xml = array2xml("page_links_list", $menu_links);
$xsl = $this->file_path . "/templates/page_content.xsl";
xml_transform($xml, $xsl);

