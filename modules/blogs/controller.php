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

//====================================================================
// Local Variables / Settings
//====================================================================
include('local.var.php');

//====================================================================
// Pull Blog Parameters
//====================================================================
$blog_params = false;
$valid_blog = false;
if (!empty($segment_3) && is_numeric($segment_3) && $blog_params = init_blog_params($site_id, $segment_3)) {
	extract($blog_params);
	$valid_blog = $segment_3;
	$blog_id = $segment_3;
}

if ($this->action == 'invalid_blog') { $segment_3 = ''; }

//====================================================================
// Flow Control
//====================================================================
if (!empty($valid_site)) {

	switch ($segment_4) {

		case "entries":
			$mod_title = "Blog Entries";
			$mod_base_url2 = $mod_base_url = "{$mod_base_url}{$blog_id}/entries/";
			$breadcrumbs[] = anchor($mod_base_url2, 'Entries');
			include("blog_entries/controller.php");
			break;

		case "cats":
			if ($acc_lvl > 2) {
				$mod_title = "Blog Categories";
				$mod_base_url2 = $mod_base_url = "{$mod_base_url}{$blog_id}/cats/";
				$breadcrumbs[] = anchor($mod_base_url2, 'Categories');
				include("blog_cats/controller.php");
			}
			else {
				add_warn_message($access_deny_msg);
				include("main.php");
			}
			break;

		default:
			switch ($this->action) {
				case "add":
				case "edit":
				case "confirm_delete":
					if ($acc_lvl < 3 && ($this->action == "add" || $this->action == "confirm_delete")) {
    					add_warn_message($access_deny_msg);
        				include("main.php");
    				}
    				else {
						$pull_from_db = true;
						include("form_controller.php");
					}
					break;
				
				case "insert":
				case "update":
				case "delete":
					if ($acc_lvl < 3 && ($this->action == "insert" || $this->action == "delete")) {
    					add_warn_message($access_deny_msg);
        				include("main.php");
    				}
    				else {
						include("db_action.php");
					}
					break;
		
				default:
					include("main.php");
					break;
			}
			break;
	}
}
else {
	redirect($this->html_path . '/');
}

