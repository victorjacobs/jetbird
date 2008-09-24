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
	
	class smarty_handler {
		var $smarty_handle, $output, $template;
		
		function __construct(){
			global $config;
			// Create smarty handle
			$this->smarty_handle = new Smarty;
			
			if(!is_readable($config['smarty']['template_dir'] . $config['smarty']['template'] . '/')){
				$this->template = "default";
			}else{
				$this->template = $config['smarty']['template'];
			}
			
			$this->smarty_handle->template_dir = $config['smarty']['template_dir'] . $this->template . '/';
			$this->smarty_handle->compile_dir = $config['smarty']['compile_dir'];
			$this->smarty_handle->cache_dir = $config['smarty']['cache_dir'];
			$this->smarty_handle->config_dir = $config['smarty']['config_dir'];
			$this->smarty_handle->compile_id = $this->template;
		}
		
		function display($file){
			$this->smarty_handle->display($file);
		}
		
		function assign($var, $value){
			$this->smarty_handle->assign($var, $value);
		}
		
		function fetch($file){
			return $this->smarty_handle->fetch($file);
		}
	}

?>