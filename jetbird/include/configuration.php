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
	
	// Global config
	$config['global']['timestamp'] = "j/m/y";
	$config['global']['timezone'] = "CET";
	
	// RSS
	$config['rss']['format'] = "rss2.0";
	$config['rss']['title'] = "Jetbird";
	$config['rss']['link'] = "http://localhost/jetbird/";
	$config['rss']['description'] = "The everyday problems of two geeks";
	$config['rss']['ttl'] = 120;
	
	// Database config
	$config['database']['host'] = "";
	$config['database']['user'] = "";
	$config['database']['pass'] = "";
	$config['database']['database'] = "";
	
	// Smarty config
	$config['smarty']['template_dir'] = "template/";
	$config['smarty']['template'] = "rss";
	$config['smarty']['compile_dir'] = "include/smarty/templates_c";
	$config['smarty']['cache_dir'] = "include/smarty/cache";
	$config['smarty']['config_dir'] = "include/smarty/configs";

?>