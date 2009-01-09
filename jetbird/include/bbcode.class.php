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
	
	class bbcode{
		private $tree;
		
		public function __construct($string){
			echo "<pre>";
			var_dump($string);
			var_dump($this->build_tree($string));
			echo "</pre>";
		}
		
		public function parse(){
			
		}
		
		private function build_tree($string){
			$blocks = preg_split("/(\[\/{0,1}[^\]]+\])/i", $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			
			$level = 0;
			$this->tree = array();
			$parent = &$this->tree;
			$tree_refs[] = $parent;
			
			foreach($blocks as $text_block){
				if($text_block{0} == "["){			// The bbtags are normally at predictable places, but let's be sure
					if($text_block{1} == "/"){		// Tag gets closed
						$level--;
						$parent = $tree_refs[$level];
					}else{							// Tag opened
						$level++;
						$tree_refs[$level] = $parent;
						$parent[$text_block] = array();
						$parent = &$parent[$text_block];
					}
				}else{								// We are dealing with char data here
					$parent['data'] = $text_block;
				}
				
			}
			
			return $this->tree;
		}
		
		public function __destruct(){
			
		}
	}

?>