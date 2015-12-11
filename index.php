<?php
//***************************************************************************
/**
* LWCMS (Lightweight Content Mangement System)
*
* @package		LWCMS
* @subpackage	Main_Controller
* @author 		Christian J. Clark
* @copyright	Copyright (c) Christian J. Clark
* @license		http://www.gnu.org/licenses/gpl-2.0.txt
* @link			http://www.emonlade.net/lwcms/
**/
//***************************************************************************

//*************************************************************************
//*************************************************************************
// Main Application Controller
//*************************************************************************
//*************************************************************************
define('MAIN_CONTROLLER', 1);

//*************************************************************************
// Is Redirect URL Set?
//*************************************************************************
if (!isset($_SERVER['REDIRECT_URL'])) {
	$_SERVER['REDIRECT_URL'] = $_SERVER['REQUEST_URI'];
}

//*************************************************************************
// OpenCore "Pseudo" Content Devlivery Network
//*************************************************************************
include('phar://' . __DIR__ . '/lib/opencore.phar/cdn.inc.php');

//*************************************************************************
// Start the session
//*************************************************************************
session_start();

//*************************************************************************
// Load the configuration if necessary
//*************************************************************************
if (!isset($_SESSION["frame_path"])) {
	include("config.inc.php");
	$_SESSION["file_path"] = dirname(__FILE__);
	include("$config_arr[frame_path]/main_controller.php");
}
else {
	include("$_SESSION[frame_path]/main_controller.php");
}

