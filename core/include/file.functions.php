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
	
	// Functions for reading and manipulating files

	/*
	*	Hard Core file mime fetching
	*
	*	WARNING: This function is FAR from perfect, since some file types tend to have
	*		weird headers that aren't constant etc. BUT the image types supported by gd
	*		do have nice headers.
	*
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
	*	2066 => mov				>> Don't rely on this one
	*	1866 => mp4				>> Same...
	*	4944 => mp3
	*
	*	Problems with:
	*	- iso files > don't seem to have a header
	*	- mp4 and mov files have the same signature cause they are essentially the same
	*	- mpg files have two mime types: audio/mpeg and video/mpeg
	*	- m4a, m4v and mov have same signature
	*/
	
	function get_file_signature($file){
		if(!($handle = @fopen($file, "r"))){
			return false;
		}
			
		$signature = bin2hex(fgets($handle, 3));
		
		// If first three bytes don't give us anything, try to move pointer further but within limits
		// Note: fgets moves pointer, in other words: fgetc gets the character after the last one from the
		//  fgets call
		if(substr($signature, 0, 2) == "00"){
			while(bin2hex(fgetc($handle)) == "00"){
				if(ftell($handle) > 128){
					return false;
				}
			}
			fseek($handle, ftell($handle) - 1);						// fgetc() moves the pointer foo far
			
			$signature = bin2hex(fgets($handle, 3));
		}
		
		fclose($handle);
		
		return $signature;
	}
	
	function read_mime($file){
		switch(get_file_signature($file)){
			case "8950": return "image/png"; break;
			case "ffd8": return "image/jpeg"; break;
			case "4749": return "image/gif"; break;
			
			case "4d5a": return "application/octet-stream"; break;
			case "504b": return "application/zip"; break;
			case "5261": return "application/x-rar-compressed"; break;
			case "377a": return "application/x-7z-compressed"; break;
			case "2550": return "application/pdf"; break;
			case "d0cf": return "application/msword"; break;
			case "5249": return "video/avi"; break;
			case "3026": return "video/x-ms-wmv"; break;
			//case "2066": return "video/quicktime"; break;
			case "1866": return "video/mp4"; break;
			case "4944": return "audio/mpeg"; break;
			
			default: return false; break;
		}
	}

?>