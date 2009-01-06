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
	
	$key = addslashes($_GET['key']);
	
	if(!isset($_GET['key'])){
		if(function_exists("redirect")){
			redirect("./");
		}else{
			die();
		}
	}
	
	$query = "SELECT * FROM user WHERE user_reg_key = '". $key ."'";
	$user_info = $db->fetch_array($query);
		
	if(count($user_info) == 1){			
		if(isset($_POST['submit'])){
			// Checks	
			if(strtolower($_SESSION['captcha']) != strtolower($_POST['captcha'])){
				$register_error['captcha'] = true;
			}
			unset($_SESSION['captcha']);
			
			if(isset($_POST['pass']) && !empty($_POST['pass'])){
				if($_POST['pass'] != $_POST['pass_confirm']){
					$register_error['pass_confirm'] = true;
				}
			}else{
				$register_error['pass'] = true;
			}
			
			if(isset($_POST['username']) && !empty($_POST['username'])){
				if($db->num_rows("SELECT * FROM user WHERE user_name = '". $_POST['username'] ."'") == 1){
					$register_error['username_exists'] = true;
				}
			}else{
				$register_error['username'] = true;
			}
			
			if(!isset($_POST['mail']) || empty($_POST['mail'])){
				$register_error["mail"] = true;
			}elseif(!check_email_address($_POST['mail'])){
				$register_error["mail_invalid"] = true;
			}
			
			// Output			
			if(count($register_error) != 0){
				$smarty->assign("register_error", $register_error);
				$smarty->assign("register_data", $_POST);				
			}else{
				$pass_encrypted = md5($_POST['pass']);
				
				// Use the user_id fetched earlier on to enter user info
				$db->query(
				"	UPDATE user
					SET user_name = '". $_POST['username'] ."',
					user_pass = '". $pass_encrypted ."',
					user_level = 1,
					user_mail = '". $_POST['mail'] ."',
					user_reg_key = '',
					user_last_login = 0
					WHERE user_id = '". $user_info[0]['user_id'] ."'
				");
				
				$smarty->assign("success", true);
				redirect('./?login', 2);
			}
		}
	}else{
		redirect("./");		// Note: lame thing to do			
	}
	
	$smarty->display("register.tpl");

?>