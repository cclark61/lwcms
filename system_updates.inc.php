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
//****************************************************************************
// Application System Updater
//****************************************************************************
//****************************************************************************

//-----------------------------------------------
// Set Last Update Number
//-----------------------------------------------
$last_update = 48;

//****************************************************************************
// Check if System Updates Table exists, create it if not
//****************************************************************************
if (!lwcms_db_table_exists('system_updates')) {
	$sql_system_update_table = "
		CREATE TABLE IF NOT EXISTS `system_updates` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`update_num` int(11) NOT NULL,
		`update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
	";
	qdb_list($_SESSION["lwcms_ds"], $sql_system_update_table);

	//-----------------------------------------------
	// Check that the system updates table exists
	//-----------------------------------------------
	if (!lwcms_db_table_exists('system_updates')) {
		$err_msg = '[!!] Error: Could not create the system updates table.';
		$err_msg .= ' Please make sure the database user for LWCMS has privileges to modify the database.';
		show_error_message($err_msg);
		session_unset();
		session_destroy();
		exit;
	}
}

//****************************************************************************
// Check if Application Settings Table exists, create it if not
//****************************************************************************
if (!lwcms_db_table_exists('app_settings')) {
	$sql_app_settings_table = "
		CREATE TABLE `app_settings` (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`site_id` INT NOT NULL DEFAULT '0',
		`module_id` INT NOT NULL DEFAULT '0',
		`option_name` VARCHAR( 50 ) NOT NULL ,
		`option_value` VARCHAR( 100 ) NOT NULL ,
		`spare_key` VARCHAR( 50 ) NULL
		) ENGINE = InnoDB
	";
	qdb_list($_SESSION["lwcms_ds"], $sql_app_settings_table);

	//-----------------------------------------------
	// Check that the system updates table exists
	//-----------------------------------------------
	if (!lwcms_db_table_exists('app_settings')) {
		$err_msg = '[!!] Error: Could not create the application settings table.';
		$err_msg .= ' Please make sure the database user for LWCMS has privileges to modify the database.';
		show_error_message($err_msg);
		session_unset();
		session_destroy();
		exit;
	}
}

//****************************************************************************
//****************************************************************************
// SQL Updates
//****************************************************************************
//****************************************************************************
$sql_updates = array();

//-----------------------------------------------
// Pull updates already performed
//-----------------------------------------------
$strsql = "select * from system_updates order by update_num";
$cus = qdb_list($_SESSION["lwcms_ds"], $strsql, "update_num:update_date");

//-----------------------------------------------
// Check for available updates
//-----------------------------------------------
for ($i = 0; $i <= $last_update; $i++) {
	$curr_update_file = dirname(__FILE__) . '/updates/sql/sql_update_' . $i . '.php';
	if (!isset($cus[$i]) && file_exists($curr_update_file)) {
		include($curr_update_file);
	}
}

//****************************************************************************
//****************************************************************************
//**************************************************************************** 
// Check which updates have been done, perform oustanding updates
//****************************************************************************
//****************************************************************************
//**************************************************************************** 
foreach ($sql_updates as $key => $sql) {
	if (!isset($cus[$key])) {
		if (is_array($sql)) {
			foreach ($sql as $tmp_sql) {
				qdb_list($_SESSION["lwcms_ds"], $tmp_sql);
			}
		}
		else {
			qdb_list($_SESSION["lwcms_ds"], $sql);
		}
		$in_sql = "insert into system_updates (update_num) values (?)";
		qdb_exec($_SESSION["lwcms_ds"], $in_sql, array('i', $key));
	}
}

//****************************************************************************
//**************************************************************************** 
// Update Error Function
//****************************************************************************
//**************************************************************************** 
function show_error_message($err_msg)
{
	$styles = 'padding: 15px; margin: 10px; background: #F2BFBF; border: 2px #E68080 solid; color: #333333; font-family: Verdana';
	$err_attrs = array('style' => $styles);
	print new gen_element('div', $err_msg, $err_attrs);
}


