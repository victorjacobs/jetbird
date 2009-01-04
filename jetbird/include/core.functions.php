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
	
	
	/*
	*	Hard Core file mime fetching
	*
	*	First three bytes, converted to hex value:
	*	bin2hex(fgets($handle, 3));
	*	
	*	These bytes (the signature of a file) tell us enough:
	*	8950 => png
	*	FFD8 => jpg (SOI)
	*	4749 => gif
	*	4d5a => exe
	*	504b => zip
	*	5261 => rar
	*	377a => 7zip
	*	2550 => pdf
	*	d0cf => word 2003 doc
	*	5249 => avi
	*	3026 => wmv
	*
	*	Problems with:
	*	- iso files > don't seem to have a header
	*	- mp4 and mov files have the same signature cause they are essentially the same
	*	- mpg files have two mime types: audio/mpeg and video/mpeg
	*/
	
	function get_file_signature($file){
		if(!($handle = @fopen($file, "r"))){
			return false;
		}
			
		$signature = bin2hex(fgets($handle, 3));
		
		// If first three bytes don't give us anything, try to move pointer further but within limits
		// Note: fgets moves pointer, in other words: fgetc gets the character after the last one from the
		//  fgets call
		if($signature == 0){
			while(bin2hex(fgetc($handle)) == 0){
				if(ftell($handle) > 128){
					return false;
				}
			}
			$signature = bin2hex(fgets($handle, 3));
		}
		
		fclose($handle);
		
		return $signature;
	}
	
	function read_mime($file){
		switch(get_file_signature($file)){
			case "8950": return "image/png"; break;
			case "FFD8": return "image/jpeg"; break;
			case "4749": return "image/gif"; break;
			case "4d5a": return "application/octet-stream"; break;
			case "504b": return "application/zip"; break;
			case "5261": return "application/x-rar-compressed"; break;
			case "377a": return "application/x-7z-compressed"; break;
			case "2550": return "application/pdf"; break;
			case "d0cf": return "application/msword"; break;
			case "5249": return "video/avi"; break;
			case "3026": return "video/x-ms-wmv"; break;
			
			default: return false; break;
		}
	}
	
	// Some general functions
	function BBCode($string){
		// Clean up the input
		$string = htmlentities($string);
		
		$search = array(
			'/\[b\](.*?)\[\/b\]/is',
			'/\[i\](.*?)\[\/i\]/is',
			'/\[u\](.*?)\[\/u\]/is',
			'/\[img\](.*?)\[\/img\]/is',
			'/\[url\=(.*?)\](.*?)\[\/url\]/is',
			'/\[url\](.*?)\[\/url\]/is',
			'/\[code\](.*?)\[\/code\]/is'
		);
		
		$replace = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<u>$1</u>',
			'<img src="$1" alt="" />',
			'<a href="$1">$2</a>',
			'<a href="$1">$1</a>',
			'<code>$1</code>'
		);
		
		return preg_replace($search, $replace, $string);
	}
	
	function truncate($string, $limit, $break = ".", $pad = "."){
		if(strlen($string) <= $limit) return $string;
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}
	
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
	
	function check_email_address($email) {
	    // First, we check that there's one @ symbol, and that the lengths are right
	    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
	        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
	        return false;
	    }
	    // Split it into sections to make life easier
	    $email_array = explode("@", $email);
	    $local_array = explode(".", $email_array[0]);
	    for ($i = 0; $i < sizeof($local_array); $i++) {
	        if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
	            return false;
	        }
	    } 
	    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
	        $domain_array = explode(".", $email_array[1]);
	        if (sizeof($domain_array) < 2) {
	            return false; // Not enough parts to domain
	        }
	        for ($i = 0; $i < sizeof($domain_array); $i++) {
	            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
	                return false;
	            }
	        }
	    }
	    return true;
	}

?>