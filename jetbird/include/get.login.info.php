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
	
	// Prevent weird stuff from happening
	$user['logged_in'] = false;
	
	if(isset($_SESSION['user'])){
		$user['name'] = &$_SESSION['username'];
		$user['id'] = &$_SESSION['user_id']
		$user['method'] = "session";
		$user['logged_in'] = true;
	}elseif(isset($_COOKIE['user'])){			// Just leave this in here for later
		$user['name'] = $_SESSION['username'];
		$user['id'] = $_SESSION['user_id']
		$user['method'] = "cookie";
		$user['logged_in'] = true;
	}
	
	if($user['logged_in']){
		$user_info = $dbconnection->fetch_array("SELECT * FROM users WHERE user_id = '". $user['id'] ."'");
		$user['auth_id'] = $user_info['auth_id'];
	}

?>