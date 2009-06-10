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
	
	if(isset($_COOKIE['login_key']) && !$_SESSION['login']){
		// Let's check whether the login_key is valid
		$session_info_query = $db->query("	SELECT *
											FROM user_session
											WHERE user_session_key = '". $_COOKIE['login_key'] ."'");
		
		if($db->num_rows($session_info_query) == 1){
			$session_info = $db->fetch_array($session_info_query);
			
			/* This next block of code assumes that the login can't expire while
			 * browsing the site (because it the block is located under a !$_SESSION
			 * statement). I don't know if this a good thing to do. But normally
			 * it won't be a problem, only if someone changes $config['global']['login_expire']
			 * while people are logged in. But then again, what difference will that make.
			*/
			if($session_info[0]['user_session_age'] + $config['global']['login_expire'] <= time()){
				$db->query("DELETE FROM user_session
							WHERE user_session_key = '". $_COOKIE['login_key'] ."'");
				cookie_destroy("login_key");
			}else{
				// Refresh cookie with same login_key
				setcookie('login_key', $_COOKIE['login_key'], time() + $config['global']['login_expire']);
				
				$user_info = $db->fetch_array("	SELECT *
												FROM user
												WHERE user_id = ". $session_info[0]['user_session_uid']);
				
				$_SESSION['user_level'] = $user_info[0]['user_level'];
				$_SESSION['user_name'] = $user_info[0]['user_name'];
				$_SESSION['user_id'] = $user_info[0]['user_id'];
				$_SESSION['login'] = true;

				// Since our session expired, we are essentially just logging in again
				// TODO: remove or the update in user_session, or the update in user,
				//  kinda doing double work here
				$db->query("UPDATE user
							SET user_last_login = ". time() ."
							WHERE user_id = ". $session_info[0]['user_session_uid']);

				$db->query("UPDATE user_session
							SET user_session_age = ". time() ."
							WHERE user_session_id = ". $session_info[0]['user_session_id']);
			}
			
		}else{
			// Destroy the cookie, since it's invalid
			cookie_destroy("login_key");
		}
	}

?>