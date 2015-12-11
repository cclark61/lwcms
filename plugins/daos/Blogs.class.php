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
// Blogs Class
//***************************************************************************
class Blogs
{

	//***********************************************************************
	//***********************************************************************
	// Initialize Blog Parameters Function
	//***********************************************************************
	//***********************************************************************
	public static function init_blog_params($site_id, $blog_id)
	{
		$blog_params = array();
		$db_params = array('ii', $blog_id, $site_id);
		$strsql = 'select * from site_blogs where id = ? and site_id = ?';
		$blog_recs = qdb_exec('', $strsql, $db_params);
		if (count($blog_recs) > 0) {
			$blog_params['valid_blog'] = $blog_id;
			$blog_params['blog_id'] = $blog_id;
			$blog_params['blog_url'] = $blog_recs[0]['blog_url'];
			$blog_params['blog_title'] = $blog_recs[0]['blog_title'];
		}
		else {
			$blog_params['warn_message'] = 'Invalid Blog!';
			$blog_params['valid_blog'] = false;
		}
		
		return $blog_params;
	}

}

