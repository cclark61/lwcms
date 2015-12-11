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

//***************************************************************************
//***************************************************************************
// Update Active Site Modules Function
//***************************************************************************
//***************************************************************************
function update_asms($site_id)
{
	$strsql = "select * from app_modules order by mod_desc";
	$app_modules = qdb_list('', $strsql); // Ok

	$active_mods = array();
	foreach ($app_modules as $smod) {
		$tmp_var = "site_mod_" . $smod["id"];
		if (isset($_POST[$tmp_var]) && $_POST[$tmp_var] == 1) {
			$active_mods[] = $smod["id"];
		}
	}

	//----------------------------------------------------------------
	// Remove Previous Records
	//----------------------------------------------------------------
	qdb_exec('', "delete from active_site_modules where site_id = ?", array('i', $site_id));
	
	//----------------------------------------------------------------
	// Insert New Records
	//----------------------------------------------------------------
	foreach ($active_mods as $amod) {
		qdb_exec('', "insert into active_site_modules (site_id, module_id) values (?, ?)", array('ii', $site_id, $amod));
	}
}

