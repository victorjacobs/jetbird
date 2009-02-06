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
	
	/* Generic class definition for safely storing data
	*  Doing it this way cause we don't want other people fiddling around in
	*  the data.
	*  NOTE: this can't be moved to an include, since this is the bootstrapper
	*/
	class data{
		// Restrict access
		private $data;
		
		public function __construct($data){
			if(empty($data)){
				return false;
			}
			$this->data = $data;
		}
		
		public function read(){
			return $this->data;
		}
		
		public function __destruct(){
			unset($this->data);
		}
	}
	
	// Look for the includes directory, but within reasonable limits
	$dir = "include/";
	$level = 0;
	while(!file_exists($dir) && $level < 5){
		$dir = "../". $dir;
		$level++;
	}
	
	$dh = opendir($dir);
	
	while(($file = readdir($dh)) !== false){
		$temp = explode(".", $file);
		if(!is_dir($dir . $file) && $file != ".DS_Store" && end($temp) == "php" && $file != "bootstrap.php"){
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
	
	// Hardcode some modules
	$classes['smarty'] = $dir . "smarty/Smarty.class.php";
	$classes['pel_jpeg'] = $dir . "pel/PelJpeg.php";
	
	$includes_data = new data(array("functions" => $functions,
									"classes" => $classes,
									"private" => $private));
	
	// Clean up
	closedir($dh);
	unset($functions, $classes, $private, $dh, $dir, $level, $file, $temp);
	
	function load($load_file){
		global $includes_data;
		$files = $includes_data->read();
		
		if(!empty($files['functions'][$load_file])){
			require_once $files['functions'][$load_file];
		}
		if(!empty($files['classes'][$load_file])){
			require_once $files['classes'][$load_file];
		}
		if(!empty($files['private'][$load_file])){
			$backtrace = debug_backtrace();

			if(count($backtrace) != 1){		// Someone's trying to load private includes
				return false;
			}
			
			// Make some vars global, otherwise they'll only last in this function
			global $db, $config;
			require_once $files['private'][$load_file];
		}		
	}

?>