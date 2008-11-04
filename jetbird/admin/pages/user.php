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
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	switch($action){
		case "invite":		
			if(isset($_POST['submit'])){
				$key = crypt(uniqid(sha1(md5(rand())), true));
								
				// putting key into DB
				$query = "INSERT INTO user (user_reg_key) VALUES ('$key')";
				$dbconnection->query($query);
			}		
		break;
		
		case "edit":
			$query = "SELECT * FROM user";
			$smarty->assign("users", $dbconnection->fetch_array($query));
			
			if (isset($_POST['name'])) {
				$query = "	UPDATE user
							SET user_name = '". $_POST['user_name'] ."',
							user_mail = '". $_POST['user_mail'] ."',
							user_level = '". $_POST['user_level'] ."'
							WHERE user_id = '". $_GET['id'] ."'";
				$dbconnection->query($query);
			}
		break;
		
		case "delete":
			if (isset($_POST['submit'])) {
				$query = "	DELETE FROM user
							WHERE user_id ='". $_GET['id'] ."'";
				$dbconnection->query($query);
			}
		break;
		
		default:
			$query = "SELECT * FROM user";
			$smarty->assign("users", $dbconnection->fetch_array($query));
		break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display('admin.user.tpl');
	
		
	
	

?>