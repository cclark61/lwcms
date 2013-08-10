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
// Update #18
// Create content_versions table
//****************************************************************************
if (!lwcms_db_table_exists('content_versions')) {
	$sql_updates[18] = "
		CREATE TABLE `content_versions` (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`create_user` VARCHAR( 30 ) NOT NULL ,
		`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
		`content_type` VARCHAR( 10 ) NOT NULL ,
		`entry_id` INT NOT NULL ,
		`indexed_content` TEXT NULL ,
		`raw_content` BLOB NULL DEFAULT ''
		) ENGINE = InnoDB
	";
}

?>
