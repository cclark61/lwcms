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

class site_blog_cat extends database_interface_object
{	
	// Constructor function
	public function __construct()
	{
		$this->set_data_source($_SESSION["lwcms_ds"], "site_blog_cats");
		$this->set_pkey("id");
		$this->set_save_default("active", 0);
		$this->use_bind_params();
		$this->no_save("id");
	}
}

?>