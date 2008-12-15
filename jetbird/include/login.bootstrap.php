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
	
	if($_COOKIE['logged_in_as'] != $_SESSION['logged_in_as']){		// Session expired, but we are still logged in by cookie
		echo "<b>Debug:</b> Bootstrapping login";
		// Refresh the cookie's expire timer by setting new uniqid
		$login_id = uniqid();
		setcookie('logged_in_as', $login_id);	// TODO: add expire here
		$_SESSION['logged_in_as'] = $login_id;
		
		// Re-set all other session vars, we assume here that $_COOKIE['user_id'] was a valid user id
		//  since it was set using the login script
		$query = "	SELECT *
					FROM user
					WHERE user_id = ". $_COOKIE['user_id'];
		$user = $dbconnection->fetch_array($query);
		
		$_SESSION['user_level'] = $user[0]['user_level'];
		$_SESSION['username'] = $user[0]['user_name'];
		$_SESSION['user_id'] = $user[0]['user_id'];
		$_SESSION['login'] = true;
		
		// Since our session expired, we are essentially just logging in again
		$dbconnection->query("	UPDATE user
								SET user_last_login = ". time() ."
								WHERE user_id = ". $user[0]['user_id']);
	}

?>