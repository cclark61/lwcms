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

if (isset($_POST["update_pass"])) {

	// Check for form key
	$do_trans = check_and_clear_form_key($this, "form_key", $form_key);

	if ($do_trans) {
		if (get_saveable_password($curr_pass) == $_SESSION["passwd"]) {
			if ($new_pass1 == $new_pass2) {
				$enc_new_pass = get_saveable_password($new_pass1);
				$strsql = "update users set password = ? where userid = ?";
				qdb_exec('', $strsql, array('ss', $enc_new_pass, $_SESSION['userid']));
				$_SESSION["passwd"] = $enc_new_pass;
				$_SESSION['action_message'][] = "Your password has been changed!";
				header("Location: {$this->html_path}/");
				exit;
			}
			else {
				add_warn_message("New passwords do not match! Please try again.");
				include("form.php");
			}
		}
		else {
			add_warn_message("Incorrect current password! Please try again.");
			include("form.php");
		}
	}
	else {
		header("Location: {$this->html_path}/");
		exit;
	}
}
else {
	include("form.php");
}

?>
