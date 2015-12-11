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

$breadcrumbs[] = anchor("{$this->html_path}/{$site_id}/", html_escape($site_name));

//=====================================================================
// Module Title
//=====================================================================
$mod_title = $site_name;

//=====================================================================
// Pull a list of active site modules
//=====================================================================
$strsql = "
	select * from 
		app_modules a, 
		active_site_modules b
	where 
		a.id = b.module_id 
		and b.site_id = ?
	order by 
		a.mod_desc
";
$db_params = array('i', $site_id);
$active_modules = qdb_exec('', $strsql, $db_params);
$curr_site_modules = qdb_exec('', $strsql, $db_params, 'phrase:module_id');
$this->set_mod_var('active_site_mods', $curr_site_modules);

//=====================================================================
// Pull user module access
//=====================================================================
$lwcms_user_access = lwcms_get_site_mod_access($site_id, $site_name);
$this->set_mod_var('lwcms_user_access', $lwcms_user_access);

$ttl_mods = 0;

ob_start();
foreach ($active_modules as $key => $amod) {
	extract($amod);
	if ($admin_status > 0 || isset($lwcms_user_access[$phrase])) {
		$tmp_image = css_icon($image);
		$mod_url = "{$mod_base_url}{$site_id}/{$phrase}/";
		print li(anchor($mod_url, $tmp_image . html_escape($mod_desc)));
		$ttl_mods++;
	}
}

$site_nav = ob_get_clean();
if ($ttl_mods > 0) {
	print ul($site_nav, array('class' => 'site_nav sub-modules-nav nav nav-pills nav-stacked'));
}

