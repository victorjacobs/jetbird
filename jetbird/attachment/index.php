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
	require_once "../include/bootstrap.php";
	
	load("core");
	load("configuration");
	load("database_connect");
	
	// Find attachment directory, since $config gives us a path relative to jetbird's root
	// NOTE: Need to find out how this code behaves on windows hosts
	if($config['uploader']['upload_dir']{0} == "/"){
		$config['uploader']['upload_dir'] = "..". $config['uploader']['upload_dir'];
	}else{
		$config['uploader']['upload_dir'] = "../". $config['uploader']['upload_dir'];
	}
	
	// Getting ready for the real deal: including our pages
	$arguments = array_keys($_GET);
	
	if(isset($arguments)){
		if(file_exists("page/". $arguments[0] .".php") && is_readable("page/". $arguments[0] .".php")){
			require_once "page/". strtolower($arguments[0]) .".php";
		}else{
			redirect("../");
		}
	}
	
	$db->close();

?>