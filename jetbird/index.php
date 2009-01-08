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
	//making sure all the data we recieve is UTF-8, 
	//from now on there is only one charset in the world for me: UTF-8
	header('Content-Type: text/html; charset=utf-8');
	require_once "include/core.functions.php";
	$process_start = timer();		// Use this wherever you want, can be useful for debugging
	require_once "include/configuration.php";
	require_once "include/database.handler.class.php";
	require_once "include/database.connect.php";
	require_once "include/search.functions.php";
	require_once "include/smarty/Smarty.class.php";
	require_once "include/smarty.handler.class.php";
	require_once "include/login.bootstrap.php";

	$smarty = new smarty_handler;
	
	// Getting ready for the real deal: including our pages
	$arguments = array_keys($_GET);
	$action = addslashes($arguments[1]);
	
	if(isset($arguments[0]) && !eregi("^[a-z0-9_-]+$", $arguments[0])){
		redirect("./");
	}
	
	if(isset($arguments)){
		if(file_exists("pages/". $arguments[0] .".php") && is_readable("pages/". $arguments[0] .".php")){
			require_once "pages/". strtolower($arguments[0]) .".php";
		}elseif(empty($arguments[0]) || !empty($_GET[$arguments[0]])){		// if arguments for specific page like ./?page=1
			require_once "pages/main.php";
		}elseif(file_exists($smarty->template_dir ."/static/". $arguments[0] .".tpl") && is_readable($smarty->template_dir ."/static/". $arguments[0] .".tpl")){
			// These pages are called static for a reason, so let's enable smarty caching
			$smarty->caching = 1;
			$smarty->display("static/". $arguments[0] .".tpl");
		}
	}
	
	$dbconnection->close();
	
	ob_end_flush();

?>