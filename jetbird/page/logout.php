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
	
	if(!function_exists("redirect")){		// This means that this page hasn't been included right
		die();
	}
	
	if(isset($_COOKIE['logged_in_as'])){
		cookie_destroy("logged_in_as", "user_id");
	}
	
	// Let's be nice to other people who might be needing $_SESSION
	unset($_SESSION['user_level']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_id']);
	unset($_SESSION['login']);
	
	redirect('./');

?>