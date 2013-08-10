<?php

//====================================================================
// Set Default Return Value
//====================================================================
$ret_val = false;

//====================================================================
// Pull Site Info Based on a URL Passed
//====================================================================
if (isset($in_url)) {
	$dec_url = base64_decode($in_url);
	if ($dec_url) {
		$url_args = explode('/', $dec_url);
		if ($url_args) {
			$site_id = ($url_args[0]) ? ($url_args[0]) : (false);
			if ($site_id === false && !empty($url_args[1])) {
				$site_id = $url_args[1];
			}
			settype($site_id, 'int');

			$site_info = get_site_info($site_id);
			if ($site_info) {
				print json_encode($site_info);
			}
		}
	}
}

//====================================================================
// Invalid, return false
//====================================================================
return $ret_val;

?>