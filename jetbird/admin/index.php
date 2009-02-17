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
	
	// Note: this page is very similar to the main index.php
	
	// Global init
	define("ADMIN_MODE", true);
	ob_start();
	session_start();
	// Make sure all the data we recieve is UTF-8, 
	// from now on there is only one charset in the world for me: UTF-8
	header('Content-Type: text/html; charset=utf-8');
	
	require_once "../include/bootstrap.php";
	
	load("core");
	$process_start = timer();		// Use this wherever you want, can be useful for debugging
	load("configuration");
	load("text");
	load("database_connect");
	load("smarty_glue");
	load("login_bootstrap");
	
	// We don't want regular users to sniff around in here
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		redirect("../");
		die();
	}
	
	$smarty = new smarty_glue;
	
	// Getting ready for the real deal: including our pages
	$arguments = array_keys($_GET);
	
	$action = $arguments[1];
	
	if(isset($arguments) && file_exists("page/". $arguments[0] .".php") && is_readable("page/". $arguments[0] .".php") && eregi("^[a-z0-9_-]+$", $arguments[0])){
		$include = strtolower($arguments[0]);
	}elseif(empty($arguments[0]) || !empty($_GET[$arguments[0]])){		// if arguments for specific page like ./?page=1
		$include = "main";
	}else{
		redirect("./");
	}
	
	require_once "page/". $include .".php";
	
	ob_end_flush();
	

?>