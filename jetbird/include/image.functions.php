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
	
	function gd_capabilities(){
		if(function_exists("imageCreate")){
			define("_JB_GD_INSTALLED", true);
			
			/*	Note on shorthands:
			*	($foo == "bar") ? true : false
			*/
			define("_JB_GD_GIF", (imagetypes() & IMG_GIF) ? true : false);
			define("_JB_GD_PNG", (imagetypes() & IMG_PNG) ? true : false);
			define("_JB_GD_JPEG", (imagetypes() & IMG_JPG) ? true : false);
			
		}else{
			define("_JB_GD_INSTALLED", false);
		}
	}
	
	function generate_thumbnail($file, $mime){
		global $config;
		gd_capabilities();
		
		list($file_type, $exact_type) = explode("/", $mime);
		
		if(_JB_GD_INSTALLED && $file_type = "image"){
			if($exact_type != "gif" && $exact_type != "png" && $exact_type != "jpeg") return false;
			
			if($exact_type == "gif" && !_JB_GD_GIF) return false;
			if($exact_type == "png" && !_JB_GD_PNG) return false;
			if($exact_type == "jpeg" && !_JB_GD_JPG) return false;
			
			// Load up the original and get size
			//  NOTE: use imageCreateFromString to avoid to have to check what type of image it is
			$original = imageCreateFromString(file_get_contents($file));
			$original_w = imagesX($original);
			$original_h = imagesY($original);
			
			// Only if the image is really too big, resize it
			// NOTE: if image is smaller than target size, don't do anything.
			//  We *could* copy the original to filename_thumb, but since it's the same
			//  it would be a waste of precious resources
			if($original_w > $config['uploader']['thumb_w'] || $original_h > $config['uploader']['thumb_h']){
				// If original is wider than it's high, resize the width and vice versa
				// NOTE: '>=' cause otherwise it's possible that $scale isn't computed
				if($original_w >= $original_h){
					$scaled_w = $config['uploader']['thumb_w'];
					// Figure out how much smaller that target is than original
					//  and apply it to height
					$scale = $config['uploader']['thumb_w'] / $original_w;
					$scaled_h = ceil($original_h * $scale);
				}elseif($original_w <= $original_h){
					$scaled_h = $config['uploader']['thumb_h'];
					$scale = $config['uploader']['thumb_h'] / $original_h;
					$scaled_w = ceil($original_w * $scale);
				}
			}else{
				// Break out of if($file_type = image) since no resize is needed
				return false;
			}
			
			// Scale the image
			$scaled = imageCreateTrueColor($scaled_w, $scaled_h);
			imageCopyResampled($scaled, $original,
			                   0, 0, /* dst (x,y) */
			                   0, 0, /* src (x,y) */
			                   $scaled_w, $scaled_h,
			                   $original_w, $original_h);
			
			// Store thumbs in jpeg, hope no one minds the 100% quality lol
			imageJpeg($scaled, $file ."_thumb", 100);
			
			// Let's be nice to our server
			imagedestroy($scaled);
			imagedestroy($original);
			
			return true;
		}
	}

?>