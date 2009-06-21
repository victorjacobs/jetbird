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
	
	// Bootstrap install enviroment
	ob_start();
	session_start();
	
	require_once "../include/bootstrap.php";
	
	load("core");
	$process_start = timer();		// Use this wherever you want, can be useful for debugging
	
	load("smarty_glue");
	
	// Load up a bare configuration, containing some vitals for Smarty
	require_once "data/configuration.bare.php";
	
	$smarty = new smarty_glue;
	// Use special template, seperated from normal templates
	$smarty->set_template("install");
	
	// Now the system is bootstrapped, give control to php scripts in page/*
	$arguments = array_keys($_GET);
	$action = addslashes($arguments[1]);
	
	if(isset($arguments[0]) && !eregi("^[a-z0-9_-]+$", $arguments[0])){
		redirect("./");
	}
	
	if(isset($arguments)){
		if(file_exists("page/". $arguments[0] .".php") && is_readable("page/". $arguments[0] .".php")){
			require_once "page/". strtolower($arguments[0]) .".php";
		}elseif(empty($arguments[0]) || !empty($_GET[$arguments[0]])){		// if arguments for specific page like ./?page=1
			require_once "page/main.php";
		}else{
			require_once "page/main.php";
		}
	}
	
	ob_end_flush();

?>