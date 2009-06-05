<?php

	/*  This file is part of Jetbird.
	
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
	
	load("smarty");
	
	class smarty_glue extends smarty{
		private $smarty_handle;
		public $template;
	
		public function __construct(){
			global $config;
			parent::__construct();
	
			// Look for smarty directories, since they are defined relative to jetbird root
			$this->template_dir = find_dir($config['smarty']['template_dir']);
			$this->common_dir = find_dir("template/common");
			$this->compile_dir = find_dir($config['smarty']['compile_dir']);
			$this->cache_dir = find_dir($config['smarty']['cache_dir']);
			$this->config_dir = find_dir($config['smarty']['config_dir']);
	
			if(!empty($_SESSION['template'])){
				$config['smarty']['template'] = $_SESSION['template'];
			}
	
			if(!is_readable($this->template_dir . $config['smarty']['template'] . '/') || $config['smarty']['template'] == "rss"){
				$this->template = "default";
			}else{
				$this->template = $config['smarty']['template'];
			}
	
			$this->template_dir .= $this->template;
			$this->compile_id = $this->template;
	
			// Assign some vars
			$this->assign("template_dir", $this->template_dir);
			$this->assign("common_dir", $this->common_dir);
			
			$this->register_modifier('truncate', 'truncate');
			$this->register_modifier('bbcode', 'BBCode');
			$this->register_modifier('strip_bbcode', "strip_bbcode");
		}
	
		public function set_template($template_name){
			if(file_exists(find_dir("template/") . $template_name)){
				$this->template_dir = str_replace($this->template, $template_name, $this->template_dir);
				$this->template = $template_name;
				$this->compile_id = $this->template;
				$this->assign("template_dir", $this->template_dir);
				return true;
			}else{
				return false;
			}
		}
	
		public function display_rss($file){
			global $config;
			$this->template_dir = str_replace($config['smarty']['template'], "rss", $this->template_dir);
			$this->display($file);
		}
	
		public function fetch_rss($file){
			global $config;
			$this->template_dir = str_replace($this->template, "rss", $this->template_dir);
			return $this->fetch($file);
		}
	}

?>