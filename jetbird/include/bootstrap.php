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
	
	// Define _JB_DEBUG if DEBUG_ENVIRONMENT is found in root
	if(file_exists(find_dir("DEBUG_ENVIRONMENT"))){
		define("_JB_DEBUG", true);
	}else{
		define("_JB_DEBUG", false);
	}
	
	// XDebug
	if(isset($_GET['debug'])){
		if($_COOKIE['XDEBUG_PROFILE']){
			setcookie("XDEBUG_PROFILE", false);
		}else{
			setcookie("XDEBUG_PROFILE", true);
		}
	}
	
	// Core function for finding directories not found in ./
	function find_dir($dir, $max_level = 5){
		if(empty($dir)) return false;
		
		$prefix = "";
		while(!file_exists($prefix . $dir) && $level != $max_level){
			$level++;
			$prefix .= "../";
		}
		
		return $prefix . $dir;
	}
	
	// On-the-fly template switcher, very useful for debugging
	if(!empty($_GET['template'])){
		$template = &$_GET['template'];
		if(file_exists(find_dir("template/") . $template)){
			$_SESSION['template'] = $template;
		}
	}elseif(isset($_GET['template'])){
		$_SESSION['template'] = false;
	}
	
	// Cleanup
	unset($template);
	
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
	
	
	$includes = find_dir("include/");
	
	$dh = opendir($includes);
	
	while(($file = readdir($dh)) !== false){
		if(!is_dir($includes . $file) 	&& $file != ".DS_Store"
										&& substr($file, strlen($file) - 3) == "php"
										&& $file != "bootstrap.php"){
			if(eregi("functions", $file)){
				$temp = explode(".functions", $file);
				$functions[str_replace(".", "_", $temp[0])] = $includes . $file;
			}elseif(eregi("class", $file)){
				$temp = explode(".class", $file);
				$classes[str_replace(".", "_", $temp[0])] = $includes . $file;
			}else{
				$private[str_replace(".", "_", str_replace(".php", "", $file))] = $includes . $file;
			}
		}
	}
	
	// Hardcode some modules
	$classes['smarty'] = $dir . "smarty/Smarty.class.php";
	
	$includes_data = new data(array("functions" => $functions,
									"classes" => $classes,
									"private" => $private));
	
	// Clean up
	closedir($dh);
	unset($functions, $classes, $private, $dh, $includes, $level, $file, $temp);
	
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