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
	
	switch($_GET['action']){
		case new_user:
			
			if(isset($_POST['submit'])){
				$key = crypt(uniqid(sha1(md5(rand())), true));
				$smarty->assign('key', $result);
				
				// putting key into DB
				$query = "INSERT INTO user (user_reg_key) VALUES ('$key')";
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