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
// Update #49
//**************************************************************************** 
// Create Testimonias Table if it does not exit
// 
//**************************************************************************** 
$sql_updates[49][] = "
	CREATE TABLE IF NOT EXISTS `testimonials` (
	  `id` int(11) NOT NULL,
	  `site_id` int(11) NOT NULL,
	  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `mod_date` timestamp NULL DEFAULT NULL,
	  `person_name` varchar(50) NOT NULL,
	  `testimonial` text NOT NULL,
	  `active` tinyint(1) NOT NULL DEFAULT '1'
	) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
";

$strsql = "select count(*) as count from app_modules where phrase = 'testimonials'";
$count = qdb_lookup($_SESSION["lwcms_ds"], $strsql, 'count');
$count += 0;

if (!$count) {
	$sql_updates[49][] = "INSERT INTO `app_modules` (`id`, `phrase`, `mod_desc`, `image`, `mod_dir`, `content_dir`, `version`) VALUES
		(18, 'testimonials', 'Testimonials', 'fa fa-comments-o', 'testimonials', '', NULL);
	";
}
else {
	$sql_updates[49][] = "UPDATE `app_modules` SET `image` = 'fa fa-comments-o', `version` = '0.5.5' WHERE `app_modules`.`phrase` = 'testimonials' LIMIT 1;";
}

