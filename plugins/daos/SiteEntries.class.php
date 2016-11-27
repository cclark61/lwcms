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
		global $meta_tags;

		//================================================================
		// Defaults / Extract Args
		//================================================================
		if (is_array($args)) { extract($args); }

		//================================================================
		// Pull Metadata
		//================================================================
		$strsql = 'select metadata from site_entries where id = ?';
		$json_metadata = qdb_lookup('', $strsql, 'metadata', array('i', $site_entry_id));

		//================================================================
		// Decode JSON
		//================================================================
		$metadata = (array)json_decode($json_metadata);
		if (!is_array($metadata)) { $metadata = array(); }
		return $metadata;
	}

	//***********************************************************************
	//***********************************************************************
	// Get Folder Options Method
	//***********************************************************************
	//***********************************************************************
	public static function GetFolderOptions($site_entry_id, $args=false)
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
		if ($site_entry_id == 0) {
			$json_folder_opts = '{}';
		}
		else {
			$strsql = 'select metadata from site_entries where id = ?';
			$json_folder_opts = qdb_lookup('', $strsql, 'metadata', array('i', $site_entry_id));
		}

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

	//***********************************************************************
	//***********************************************************************
	// Save Folder Options Method
	//***********************************************************************
	//***********************************************************************
	public static function SaveFolderOptions($site_entry_id, $site_id, Array $folder_opts, $args=false)
	{
		if ($site_entry_id == 0) {
			return false;
	    	$strsql = 'select count(*) as count from site_entries where site_id = ? and id = 0';
	    	$count = qdb_lookup('', $strsql, 'count', array('i', $site_id));
	    	if (!$count) {
	    		qdb_list('', 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');
	        	$strsql = "
	        		insert into site_entries (id, site_id, create_user, entry_title)
	        		values (?, ?, ?, 'Top Level')
	        	";
	        	qdb_exec('', $strsql, array('iis', $site_entry_id, $site_id, $_SESSION['userid']));
	    	}
		}
		$json_folder_opts = json_encode($FOLDER_OPTS);
	    $strsql = 'update site_entries set metadata = ? where site_id = ? and id = ?';
	    qdb_exec('', $strsql, array('sii', $json_folder_opts, SITE_ID, $id));

	}

}

