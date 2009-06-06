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
	
	// Some general functions
		
	function redirect($destination, $delay = null){
		if(empty($delay)){
			header('Location: '. $destination);
			exit();
		}else{
			header('Refresh: '. $delay .'; url='. $destination);
		}
	}
	
	// Function for debugging, gives accurate timings
	function timer(){
		list ($msec, $sec) = explode(' ', microtime());  
	    $microtime = (float)$msec + (float)$sec; 
	    return $microtime;
	}
	
	// This function fetches the url to the root of the jetbird installation
	function jetbird_root_url(){
		$page_url = 'http';
		
		if($_SERVER["HTTPS"] == "on") $page_url .= "s";
		$page_url .= "://";
		if($_SERVER["SERVER_PORT"] != "80"){
			$page_url .= $_SERVER["SERVER_NAME"] . ":".$_SERVER["SERVER_PORT"];
		}else{
			$page_url .= $_SERVER["SERVER_NAME"];
		}
		
		$page_url .= str_replace(basename($_SERVER['PHP_SELF']), "", $_SERVER['PHP_SELF']);
		
		// TODO: this following line is an ugly hack, should replace this
		if(eregi("admin/", $page_url)) $page_url = str_replace("admin/", "", $page_url);
		
		return $page_url;
	}
	
	function generate_reg_key(){
		return crypt(uniqid(sha1(md5(rand())), true));
	}
	
	function cookie_destroy(){
		if(func_num_args() == 0){
			return false;
		}
		$arguments = func_get_args();
		foreach($arguments as $cookie){
			setcookie($cookie, false);
		}
		return true;
	}
	
	function check_input($var, $escape) {
		if ($escape) {
			$var = mysql_real_escape_string($var);
		}
		return $var;
	}

?>