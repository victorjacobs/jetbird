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
	
	function BBCode($string){
		// Clean up the input
		$string = htmlspecialchars($string, UTF-8); 
		//For more info check here: http://www.phpwact.org/php/i18n/charsets
		
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
	
	function strip_bbcode($string){
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
		
		return preg_replace($search, "$1", $string);
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