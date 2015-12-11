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
// Sites Class
//***************************************************************************
class Sites
{

	//***********************************************************************
	//***********************************************************************
	// Initialize Site Parameters Function
	//***********************************************************************
	//***********************************************************************
	public static function init_site_params($site_id)
	{
		$site_params = array();
		$db_params = array('i', $site_id);
		$strsql = 'select * from sites where id = ?';
		$site_recs = qdb_exec('', $strsql, $db_params);
		if (count($site_recs) > 0) {
			foreach ($site_recs[0] as $key => $value) { 
				if ($key != "id") { $site_params[$key] = $value; }
			}
			$site_params['node_path'] = '';
			$site_params['parent'] = 0;
			$site_params['valid_site'] = $site_id;
		}
		else {
			add_warn_message('Invalid Site!');
			return false;
		}
		
		return $site_params;
	}

	//***********************************************************************
	//***********************************************************************
	// Update Active Site Modules Function
	//***********************************************************************
	//***********************************************************************
	public static function update_asms($site_id)
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

}

