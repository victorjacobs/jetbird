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
	/*	smarty config section & DB connect      
	*/
		
	/*
	/*	Login section
	*/	
	switch ($_GET['action']) {
	
		case login:
				
		if (isset($_POST['username'])) {
			$pwd = md5($_POST['password']);
			$query = "SELECT * FROM users WHERE username = '". $_POST['username'] ."' AND password = '$pwd'";
			$result = $dbconnection->query($query);	  
		
			//checking how much rows are affected
			if (mysql_num_rows($result) == 1) {
				$row = mysql_fetch_array($result);
				//setting all session variables
				$_SESSION['auth_id'] = $row['auth_id'];
				$_SESSION['login'] = 1;
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['user_id'] = $row['user_id'];
				$smarty->assign('login', TRUE);
				redirect('./?main', 2);
			} 
			else { 
			$smarty->assign('login', FALSE);
			}
		}
		break;
	/*
	/*	Logout section
	*/
		case logout:
		
			$_SESSION = array();
			session_destroy();
			redirect('./?main', 2);
			break;
	/*
	/*	register section
	*/			
		case register:
		
			if(isset($_POST['username'])){
				// variable setup
				$pwd = md5($_POST['password']);
				
				// checking if user already exists
				$query = "SELECT username FROM users WHERE username = '". $_POST['username'] ."'";
				$result = $dbconnection->query($query);
				
				//checking how much rows are affected
				if(mysql_num_rows($result) == 1){
					$smarty->assign('register', FALSE);
				}else{
				
				//creating user
				$query="INSERT INTO users (username, password, auth_id) VALUES ('". $_POST['username'] ."','$pwd', 0)";
				$result = $dbconnection->query($query);
				$smarty->assign('register', TRUE);
				redirect('./?main', 2);
				}
			}
		break;
	}	
		
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display('user.tpl');

?>