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
	
	function format_size($size){
		$suffixes = array(" bytes", " kB", " MB", " GB", " TB");
		$exp = 0;
		while($size >= 1024){
			$size /= 1024;
			$exp++;
		}
		return round($size, 2) . $suffixes[$exp];
	}
	
	function unformat_size($string_orig){
		$string = strtolower(str_replace(" ", "", $string_orig));
		$string = str_replace(",", ".", $string);		
		$suffices_old = array("b", "k", "m", "g", "t");
		$suffices = array("b" => 0, "bytes" => 0, "k" => 1, "kb" => 1, "m" => 2, "mb" => 2, "g" => 3, "gb" => 3, "t" => 4, "tb" => 4);
		$keys = array_keys($suffices);
		foreach($keys as $var){
			if(eregi('^[0-9]*\.?[0-9]+'. $var .'$', $string)){
				$string = trim(str_replace($var, "", $string));
				$suffix = $var;
				break;
			}
			if($exp == count($suffices) - 1){
				return $string_orig;
			}
		}		
		return (float)round($string * pow(1024, $suffices[$suffix]), 2);
	}

?>