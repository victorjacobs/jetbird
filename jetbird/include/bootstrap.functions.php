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
	
	// These functions are for bootstrapping our framework in both index.php's
	
	function read_includes(){
		$dir = "include/";
		if(!file_exists($dir) && file_exists("../include/")){
			$dir = "../include/";
		}
		
		$dh = opendir($dir);
		
		while(($file = readdir($dh)) !== false){
			$temp = explode(".", $file);
			if(!is_dir($dir . $file) && $file != ".DS_Store" && end($temp) == "php" && $file != "bootstrap.functions.php"){
				if(eregi("functions", $file)){
					$temp = explode(".functions", $file);
					$functions[str_replace(".", "_", $temp[0])] = $dir . $file;
				}elseif(eregi("class", $file)){
					$temp = explode(".class", $file);
					$classes[str_replace(".", "_", $temp[0])] = $dir . $file;
				}else{
					$private[str_replace(".", "_", str_replace(".php", "", $file))] = $dir . $file;
				}
			}
		}
		
		// Manually add the smarty class:
		$classes['smarty'] = $dir . "smarty/Smarty.class.php";
		
		closedir($dh);
		
		return array(	"functions" => $functions,
						"classes" => $classes,
						"private" => $private);
	}
	
	function load($load_file){
		$files = read_includes();
		
		if(!empty($files['functions'][$load_file])){
			require_once $files['functions'][$load_file];
		}elseif(!empty($files['classes'][$load_file])){
			require_once $files['classes'][$load_file];
		}elseif(!empty($files['private'][$load_file])){
			$backtrace = debug_backtrace();

			if(count($backtrace) != 1){		// Someone's trying to load private includes
				return false;
			}
			
			// Make some vars global, otherwise they'll only last in this function
			global $db, $config;
			require_once $files['private'][$load_file];
		}else{
			return false;
		}
		
		return true;
	}

?>