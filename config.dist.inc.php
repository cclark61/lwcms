<?php//***************************************************************************/*** LWCMS (Lightweight Content Mangement System)** @package		LWCMS* @author 		Christian J. Clark* @copyright	Copyright (c) Christian J. Clark* @license		http://www.gnu.org/licenses/gpl-2.0.txt* @link			http://www.emonlade.net/lwcms/**///***************************************************************************//**************************************************************************//**************************************************************************// Application Configuration//**************************************************************************//**************************************************************************//==========================================================// Path to Framework Directory//==========================================================$config_arr["frame_path"] = dirname(__FILE__) . "/lib/phpOpenFW1/framework";//**************************************************************************// Site Specific Settings//**************************************************************************//==========================================================// Title//==========================================================//$config_arr["site_title"] = "Example Company";//==========================================================// Headers//==========================================================//$config_arr["site_header"] = "Example Company";//$config_arr["msg_header"] = "Example Company";//$config_arr["msg_logo_url"] = "";//==========================================================// Footers//==========================================================//$config_arr["site_footer"] = "&copy; 2013 Example Company";//$config_arr["msg_footer"] = "&copy; 2013 Example Company";//==========================================================// Change Password Functionality [ yes (default) / no ]//==========================================================//$config_arr["change_password"] = "yes";//==========================================================// Help Page Functionality [ yes / no (default) ]//==========================================================//$config_arr["help_page"] = "no";//$config_arr["help_page_file"] = dirname(__FILE__) . "/help_page.php";//**************************************************************************//**************************************************************************// Authentication// Login Settings//**************************************************************************//**************************************************************************//***************************************************************************// Password Security// ** Options: [ clear (default), md5, sha1, sha256 ]//***************************************************************************$config_arr["auth_pass_security"] = "sha1";//***************************************************************************// Data Source to use for authentication//***************************************************************************$config_arr["auth_data_source"] = "lwcms";//***************************************************************************// Database Authentication Parameters//***************************************************************************// Users Table, User ID field, and User Password field.$config_arr["auth_user_table"] = "users";$config_arr["auth_user_field"] = "userid";$config_arr["auth_pass_field"] = "password";$config_arr["auth_fname_field"] = "first_name";$config_arr["auth_lname_field"] = "last_name";//**************************************************************************// Data Source//**************************************************************************$i = "lwcms";$data_arr[$i]["source"] = "lwcms";$data_arr[$i]["type"] = "mysqli";$data_arr[$i]["server"] = "db.example.com";$data_arr[$i]["port"] = 3306;$data_arr[$i]["user"] = "example_user";$data_arr[$i]["pass"] = "example_pass";//***************************************************************************// LWCMS Default Data Source//***************************************************************************$config_arr["lwcms_ds"] = "lwcms";?>