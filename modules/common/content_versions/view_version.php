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

//==================================================================
// Looking for latest revision 
//==================================================================
if ($version === 'latest') {
	$strsql = 'select max(id) as latest_version from content_versions where content_type = ? and entry_id = ?';
	$version = qdb_lookup('', $strsql, 'latest_version', array('si', $content_type, $id));
}

//==================================================================
// Pull a list of Records
//==================================================================
if (!empty($version)) {
	$strsql = 'select * from content_versions where content_type = ? and entry_id = ? and id = ?';
	$rec = qdb_first_row('', $strsql, array('sii', $content_type, $id, $version));
	
	if (!$rec) {
		print 'Invalid content revision.';
	}
	else {
		if ($rec['raw_content'] != '') {
			print $rec['raw_content'];	
		}
		else {
			print "No Content";
		}
	}
}
else {
	print 'No content revision found.';
}

