<?php

	/*	This file is part of Jetbird.

	    Jetbird is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.

	    Jetbird is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
	*/
	
	// Global init
	define("ADMIN_MODE", false);
	ob_start();
	session_start();
	require_once "include/functions.php";
	$process_start = timer();		// use this wherever you want, can be useful for debugging
	define("SVN_REVISION", svn_revision());
	require_once "include/configuration.php";
	require_once "include/database.handler.php";
	require_once "include/database.connect.php";
	require_once "include/smarty/Smarty.class.php";
	require_once "include/smarty.handler.class.php";
	
	$smarty = new smarty_handler();
	$config['current_url'] = current_url();
	
	// Getting ready for the real deal: including our pages
	$arguments = array_keys($_GET);
	$action = $arguments[1];
	
	if(isset($arguments) && file_exists("pages/". $arguments[0] .".php") && is_readable("pages/". $arguments[0] .".php") && eregi("^[a-z0-9_-]+$", $arguments[0])){
		$include = strtolower($arguments[0]);
	}elseif(empty($arguments[0]) || !empty($_GET[$arguments[0]])){		// if arguments for specific page like ./?page=1
		$include = "main";
	}else{
		redirect("./");
	}
	
	require_once "pages/". $include .".php";
	
	ob_end_flush();

?>