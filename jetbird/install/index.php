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
	
	// Bootstrap install enviroment
	ob_start();
	session_start();
	
	require_once "../include/bootstrap.php";
	
	load("core");
	load("smarty_glue");
	
	// Load up a bare configuration, containing some vitals for Smarty
	require_once "data/configuration.bare.php";
	
	$smarty = new smarty_glue;
	// Use special template, seperated from normal templates
	$smarty->set_template("installer");
	
	$smarty->display("index.tpl");

?>