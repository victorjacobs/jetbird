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
			if(isset($_POST['submit']) && !empty($_GET['id'])){
				// Checks
				if(!isset($_POST['user_name']) || empty($_POST['user_name'])) $user_edit_error["username"] = true;
				if(isset($_POST['user_mail']) && !empty($_POST['user_mail'])){
					if(!check_email_address($_POST['user_mail'])) $user_edit_error['mail_invalid'] = true;
				}else{
					$user_edit_error['mail'] = true;
				}
				if((!empty($_POST['pass']) && !empty($_POST['pass_confirm'])) && $_POST['pass'] == $_POST['pass_confirm']){
					$update_pass = true;
				}elseif(empty($_POST['pass']) && empty($_POST['pass_confirm'])){
					// Do nothing here, this is when we don't want to update the password
				}else{
					$user_edit_error['pass'] = true;
				}
				
				if(count($user_edit_error) == 0){
					if($update_pass){
						$pass = md5($_POST['pass']);
						$query = "	UPDATE user
									SET user_name = '". $_POST['user_name'] ."',
									user_mail = '". $_POST['user_mail'] ."',
									user_pass = '". $pass ."'
									WHERE user_id = ". $_GET['id'];
					}else{
						$query = "	UPDATE user
									SET user_name = '". $_POST['user_name'] ."',
									user_mail = '". $_POST['user_mail'] ."'
									WHERE user_id = ". $_GET['id'];
					}
					$dbconnection->query($query);
					redirect("./?user");
				}else{
					$smarty->assign("edit_error", $user_edit_error);
					$user = array($_POST);
					$smarty->assign("user", $user);
				}
			}else{
				if(empty($_GET['id'])){
					redirect("./?user");
				}

				$query = $dbconnection->query("SELECT * FROM user WHERE user_id = ". $_GET['id']);

				if($dbconnection->num_rows($query) != 1){
					redirect("./?user");
				}			

				$smarty->assign("user", $dbconnection->fetch_array($query));
			}
			
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
					if($dbconnection->query($query)){
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