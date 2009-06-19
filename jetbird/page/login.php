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
	
	if(isset($_POST['submit'])){
		if(isset($_POST['username'])){
			$password = md5($_POST['password']);
			$query = "	SELECT *
						FROM user
						WHERE user_name = '". $_POST['username'] ."'
						AND user_pass = '$password'
						AND NOT user_level = -2";
			$result = $db->query($query);
			
			if($db->num_rows($result) == 1){
				$user = $db->fetch_array($result);
				
				// Bootstrap
				if(isset($_POST['rememberlogin'])){
					// We only set one cookie here, to minimize security breaches, we set real login
					//  info in $_SESSION
					$login_key = uniqid();
					setcookie('login_key', $login_key, time() + $config['global']['login_expire']);
					
					$db->query('INSERT INTO user_session (user_session_key, user_session_uid, user_session_age)
								VALUES(\''. $login_key .'\', '. $user[0]['user_id'] .', '. time() .')');
				}
				
				$_SESSION['user_level'] = $user[0]['user_level'];
				$_SESSION['user_name'] = $user[0]['user_name'];
				$_SESSION['user_id'] = $user[0]['user_id'];
				$_SESSION['login'] = true;
				
				$db->query("UPDATE user
							SET user_last_login = ". time() ."
							WHERE user_id = ". $user[0]['user_id']);
				
				$smarty->assign('login', TRUE);
				
				redirect("./admin");
			}else{
				$smarty->assign('login', FALSE);
			}
			
		}
	}
	
	$smarty->assign('queries', $db->queries);
	$smarty->display("login.tpl");

?>