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
	switch ($_GET['action']) {
	
		case login:
				
		if (isset($_POST['username'])) {
			$pwd = md5($_POST['password']);
			$query = "SELECT * FROM user WHERE user_name = '". $_POST['username'] ."' AND user_pass = '$pwd'";
			$result = $dbconnection->query($query);	  
		
			//checking how much rows are affected
			if (mysql_num_rows($result) == 1) {
				$row = mysql_fetch_array($result);
				//setting all session variables
				$_SESSION['user_level'] = $row['user_level'];
				$_SESSION['login'] = 1;
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['user_id'] = $row['user_id'];
				$smarty->assign('login', TRUE);
				redirect('./admin', 2);
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
			redirect('./', 2);
			break;
	/*
	/*	register section
	*/	
		
		/*
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
				$query="INSERT INTO users (username, password, user_level) VALUES ('". $_POST['username'] ."','$pwd', 0)";
				$result = $dbconnection->query($query);
				$smarty->assign('register', TRUE);
				redirect('./', 2);
				}
			}
		break;
		*/
	}	
		
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display('user.tpl');

?>