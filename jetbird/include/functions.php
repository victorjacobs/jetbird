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
	
	// Some general functions
	function preview_text($text, $limit, $tags = 0) {

	    // trim text
	    $text = trim($text);

	    // strip tags if preview is without html
	    if ($tags == 0) $text = preg_replace('/\s\s+/', ' ', strip_tags($text));

	    // if strlen is smaller than limit return
	    if (strlen($text) < $limit) return $text;

	    if ($tags == 0) return substr($text, 0, $limit) . " ...";
	    else {

	        $counter = 0;
	        for ($i = 0; $i<= strlen($text); $i++) {

	            if ($text{$i} == "<") $stop = 1;

	            if ($stop != 1) {

	                $counter++;
	            }

	            if ($text{$i} == ">") $stop = 0;
	            $return .= $text{$i};

	            if ($counter >= $limit && $text{$i} == " ") break;

	        }

	        return $return . "...";
	    }

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

?>