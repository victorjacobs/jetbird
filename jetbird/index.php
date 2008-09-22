<?php

	/*This file is part of jetbird.

	    jetbird is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.

	    Foobar is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
	*/
	
	// Global init
	ob_start();
	session_start();
	require_once "include/functions.php";
	$process_start = timer();		// use this wherever you want, can be useful for debugging
	require_once "include/configuration.php";
	require_once "include/smarty/Smarty.class.php";
	require_once "include/database.connect.php";
	
	$smarty = new Smarty();

	$smarty->template_dir = 'template\default';
	$smarty->compile_dir = 'include\smarty\templates_c';
	$smarty->cache_dir = 'include\smarty\cache';
	$smarty->config_dir = 'include\smarty\configs';
	
	// Getting ready for the real deal: including our pages
	$arguments = array_keys($_GET);
	
	if(isset($args) && file_exists("pages/". $args[0] .".php") && is_readable("pages/". $args[0] .".php") && eregi("^[a-z0-9_-]+$", $args[0])){
		$include = strtolower($args[0]);
	}elseif(empty($args[0]) || !empty($_GET[$args[0]])){		// if arguments for specific page like ./?page=1
		$include = "main";
	}else{
		redirect("./");
	}
	
	require_once "pages/". $include .".php";
	
	ob_end_flush();

?>