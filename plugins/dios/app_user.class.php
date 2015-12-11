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

class app_user extends database_interface_object
{	
	// Constructor function
	public function __construct()
	{
		$this->set_data_source($_SESSION["lwcms_ds"], "users");
		$this->set_pkey("userid", true);
		$this->set_save_default("disabled", 0);
		$this->use_bind_params();
		//$this->no_save("id");
	}
}

