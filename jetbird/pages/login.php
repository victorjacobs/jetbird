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
			$result = $dbconnection->query($query);
			
			if($dbconnection->num_rows($result) == 1){
				$user = $dbconnection->fetch_array($result);
				
				// Bootstrap
				if(isset($_POST['rememberlogin'])){
					// We only set two cookies here, to minimize security breaches, we set real login
					//  info in $_SESSION
					$login_id = uniqid();
					setcookie('logged_in_as', $login_id, time() + $config['global']['login_expire']);
					setcookie('user_id', $user[0]['user_id'], time() + $config['global']['login_expire']);
					$_SESSION['logged_in_as'] = $login_id;
					
					$_SESSION['user_level'] = $user[0]['user_level'];
					$_SESSION['user_name'] = $user[0]['user_name'];
					$_SESSION['user_id'] = $user[0]['user_id'];
					$_SESSION['login'] = true;
				}else{
					$_SESSION['user_level'] = $user[0]['user_level'];
					$_SESSION['user_name'] = $user[0]['user_name'];
					$_SESSION['user_id'] = $user[0]['user_id'];
					$_SESSION['login'] = true;
				}
				
				$dbconnection->query("	UPDATE user
										SET user_last_login = ". time() ."
										WHERE user_id = ". $user[0]['user_id']);
				
				$smarty->assign('login', TRUE);
				
				redirect("./admin");
			}else{
				$smarty->assign('login', FALSE);
			}
			
		}
	}
	
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display("login.tpl");

?>