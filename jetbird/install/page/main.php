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
	
	load("configuration_manipulator");
	
	$manipulator = new configuration_manipulator;
	
	$manipulator->add_var("global/test", 20);
	$manipulator->add_var("global/jaja", "aaaa");
	$manipulator->add_var("tetten/zozo", 200);
	$manipulator->add_var("database/jazenne", true);
	
	$manipulator->write();
	
	// $config['global']['ja'] = "u moeder";
	// echo eval('echo $config["global"]["ja"];');

?>