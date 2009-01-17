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
	
	class Captcha{
		
		private function generate_code($length) {
			$possible = '23456789bcdfghjkmnpqrstvwxyz';
			
			unset($code);
			$i = 0;
			while($i < $length){ 
				$code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
				$i++;
			}
			return $code;
		}
		
		public function generate($width = 150, $height = 50, $background = "#FFFFFF", $length = 6, $font = "include/captcha.ttf"){
			$background_rgb = $this->hex2rgb($background);
			$image = imagecreate($width, $height) or die();
			$this->image = &$image;
			
			$code = $this->generate_code($length);
			$this->code = &$code;
			
			$font_size = $height * 0.75;
			$bg_color = imagecolorallocate($image, $background_rgb[0], $background_rgb[1], $background_rgb[2]);
			$text_color = imagecolorallocate($image, 20, 40, 100);
			$noise_color = imagecolorallocate($image, 100, 120, 180);
			
			// Fill background with random dots
			for($i = 0; $i < ($width * $height) / 3; $i++){
				imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
			}
			
			// Fill background with random lines
			for($i = 0; $i < ($width * $height) / 150; $i++){
				imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
			}
			
			$textbox = imagettfbbox($font_size, 0, $font, $code);
			$x = ($width - $textbox[4]) / 2;
			$y = ($height - $textbox[5]) / 2;
			imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);
		}
		
		public function display(){
			header('Content-Type: image/png');
			imagepng($this->image);
			imagedestroy($this->image);
			$_SESSION['captcha'] = $this->code;
		}
		
		public function hex2rgb($hex){
		    if ($hex[0] == '#') $hex = substr($hex, 1);

		    if (strlen($hex) == 6)
		        list($r, $g, $b) = array($hex[0].$hex[1],
		                                 $hex[2].$hex[3],
		                                 $hex[4].$hex[5]);
		    elseif (strlen($hex) == 3)
		        list($r, $g, $b) = array($hex[0].$hex[0], $hex[1].$hex[1], $hex[2].$hex[2]);
		    else
		        return false;

		    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

		    return array($r, $g, $b);
		}

	}

?>