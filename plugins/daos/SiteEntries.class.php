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
// Sites Entries Class
//***************************************************************************
class SiteEntries
{

	//***********************************************************************
	//***********************************************************************
	// Get Metadata Method
	//***********************************************************************
	//***********************************************************************
	public static function GetMetadata($site_entry_id, $args=false)
	{
		global $folder_opt_fields;
		global $folder_opt_settings;

		//================================================================
		// Defaults / Extract Args
		//================================================================
		$return_raw_vals = false;
		if (is_array($args)) { extract($args); }

		//================================================================
		// Pull Metadata
		//================================================================
		$strsql = 'select metadata from site_entries where id = ?';
		$json_folder_opts = qdb_lookup('', $strsql, 'metadata', array('i', $site_entry_id));

		//================================================================
		// Decode JSON
		//================================================================
		$FOLDER_OPTS = (array)json_decode($json_folder_opts);
		if (!is_array($FOLDER_OPTS)) { $FOLDER_OPTS = array(); }
		if (!empty($return_raw_vals)) { return $FOLDER_OPTS; }

		//================================================================
		// Format / Set to Default
		//================================================================
		foreach ($folder_opt_fields as $field => $desc) {
			if (!isset($FOLDER_OPTS[$field])) {
				$FOLDER_OPTS[$field] = 'show';
			}
		}
		foreach ($folder_opt_settings as $field => $opts) {
			$type = (isset($opts['type'])) ? ($opts['type']) : ('bool');
			$default = (isset($opts['default'])) ? ($opts['default']) : ('');

			if (!isset($FOLDER_OPTS[$field])) {
				$FOLDER_OPTS[$field] = $default;
			}
		}

		return $FOLDER_OPTS;
	}
}

