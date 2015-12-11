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

//****************************************************************************
// Update #31
// Add table 'site_entry_cats'
//****************************************************************************
if (!lwcms_db_table_exists('site_entry_cats')) {
	$sql_updates[31] = "
		CREATE TABLE IF NOT EXISTS `site_entry_cats` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `site_id` int(11) NOT NULL,
		  `folder_id` int(11) NOT NULL,
		  `create_user` varchar(50) NOT NULL,
		  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `category` varchar(200) NOT NULL,
		  `active` smallint(6) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14
	";
}

