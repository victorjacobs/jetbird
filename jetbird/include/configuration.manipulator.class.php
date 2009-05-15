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
	
	class configuration_manipulator{
		private $status, $raw_data, $out_array = array(), $out_string, $out_temp;
		
		public function __construct(){
			// Parse $config, before we check whether this is clean install.
			//  We do this because the bare configuration contains some essential default settings
			$this->parse_config_to_array();
			
			if(!file_exists(find_dir("include/") . "configuration.php")){
				$this->raw_data = file_get_contents(find_dir("data/") . "configuration.bare.php");
				echo "writing new configuration<br /><br />";
			}else{
				$this->raw_data = file_get_contents(find_dir("include/") . "configuration.php");
				echo "updating configuration<br /><br />";
			}
		}
		
		public function add_var($path, $data){
			list($parent, $child) = $this->eval_path($path);
			
			$this->out_array[$parent][$child] = $data;
		}
		
		private function parse_config_to_array(){
			global $config;
			
			// Geheugensteuntje: foreach($array as $key => $var)
			
			$this->out_array = array_merge($config, $this->out_array);
			
			// foreach($config as $parent => $var){
			// 	foreach($var as $child => $data){
			// 		$this->out_array[$parent][$child] = $data;
			// 	}
			// }
		}
		
		private function out_array_to_string(){
			// Sort out_array, TODO: sort childs
			ksort($this->out_array);
			
			foreach($this->out_array as $parent => $var){
				$this->out_temp .= '// '. ucfirst($parent) .' settings' . "\n";
				
				foreach($var as $child => $data){
					$this->out_temp .= '$config[\''. $parent .'\'][\''. $child .'\'] = ';
					
					if(is_int($data)){
						$this->out_temp .= $data . ";";
					}elseif(is_string($data)){
						$this->out_temp .= '"'. $data .'";';
					}
					
					$this->out_temp .= "\n";
				}
				
				$this->out_temp .= "\n";
			}
			
			return $this->out_temp;
		}
		
		public function test(){
			echo(nl2br($this->out_array_to_string()));
		}
		
		private function eval_path($path){
			if(empty($path)) return false;
			
			// Clean up the path
			$temp = explode("/", $path);
			if(count($temp) > 4) return false;
			if(empty($temp[0])) array_shift($temp);
			if(empty($temp[count($temp) - 1])) array_pop($temp);
			
			list($parent, $child) = $temp;
			
			return array($parent, $child);
		}
	}

?>