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
				$key = generate_reg_key();
								
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
			if(isset($_POST['submit']) && isset($_POST['id'])){
				if($dbconnection->num_rows("SELECT * FROM user WHERE user_id = ". $_POST['id'])){
					$query = "DELETE FROM user WHERE user_id = ". $_POST['id'];
					
					if(true){
						echo "success";
					}else{
						echo "fail";
					}
				}
			}
			
			die();	// we don't need smarty to show us a template here
		break;
		
		case "generate":
			if(isset($_POST['submit'])){
				if(isset($_POST['key_count']) && !empty($_POST['key_count'])){
					if(!eregi("[0-9]+", $_POST['key_count']) || $_POST['key_count'] > 10 || $_POST['key_count'] < 0) $generate_error['key_count_invalid'] = true;
				}else{
					$generate_error['key_count'] = true;
				}
				
				if(count($generate_error) == 0){
					for($i = 1; $i <= $_POST['key_count']; $i++){
						$key = generate_reg_key();
						$generated_keys[] = $key;
						
						$dbconnection->query(
						"	INSERT INTO user (user_reg_key, user_last_login, user_level)
							VALUES ('". $key ."', '". time() ."', '-1')
						");
					}
					
					$smarty->assign("keys", $generated_keys);
				}else{
					$smarty->assign("generate_error", $generate_error);
				}
			}
		break;
		
		default:
			$query = "SELECT * FROM user WHERE NOT user_level = -1";
			$smarty->assign("users", $dbconnection->fetch_array($query));
			
			$query = "SELECT * FROM user WHERE user_level = -1";
			$smarty->assign("keys", $dbconnection->fetch_array($query));
		break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display('admin.user.tpl');
	
?>