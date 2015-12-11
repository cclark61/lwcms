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
// AppModules Class
//***************************************************************************
class AppModules
{

	//*****************************************************************************
	//*****************************************************************************
	// Get App Modules
	//*****************************************************************************
	//*****************************************************************************
	public static function get($index='id')
	{
		$strsql = "select * from app_modules order by mod_desc";
		return qdb_list('', $strsql, $index); // Ok
	}

}
