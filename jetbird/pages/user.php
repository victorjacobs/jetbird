<?

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
	
	/*
	/*	Login section
	*/	
	switch($_GET['action']) {
	
		case "login":
			
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
							setcookie('logged_in_as', $login_id);	// TODO: add expire here
							setcookie('user_id', $user[0]['user_id']);
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
		
		break;
	/*
	/*	Logout section
	*/
		case "logout":
			if(isset($_COOKIE['logged_in_as'])){
				cookie_destroy("logged_in_as", "user_id");
			}
			
			// Let's be nice to other people who might be needing $_SESSION
			unset($_SESSION['user_level']);
			unset($_SESSION['user_name']);
			unset($_SESSION['user_id']);
			unset($_SESSION['login']);
			
			redirect('./');
			
			break;
	/*
	/*	register section
	*/		
		
		case "register":
			$query ="SELECT user_reg_key FROM user WHERE user_reg_key = '". $_GET['key'] ."'";
				$result = $dbconnection->query($query);
				
				if(mysql_num_rows($result) == 1) {
				
					$smarty->assign('register_key', TRUE);
					
					if(isset($_POST['username'])) {
					
						$pwd = md5($_POST['password']);	
						
						// checking if user already exists
						$query = "SELECT user_name FROM user WHERE user_name = '". $_POST['username'] ."'";
						$result = $dbconnection->query($query);
						
						//checking how much rows are affected
						if(mysql_num_rows($result) == 1){
						
							$smarty->assign('register_exist', TRUE);
							
						}
						else {
						
							//creating user
							$query="UPDATE user SET user_name = '". $_POST['username'] ."', user_pass = '$pwd', user_level = 0, user_reg_key = '' WHERE user_reg_key = '". $_GET['key'] ."'";
									
							$result = $dbconnection->query($query);

							$smarty->assign('register', TRUE);
							redirect('./', 2);
						}
					}
				} 
				else {
					$smarty->assign('register_key', FALSE);
					
			}
		break;
		
	}	
		
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display('user.tpl');

?>