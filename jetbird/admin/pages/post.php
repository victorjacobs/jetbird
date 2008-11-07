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
		case "new":
			
			if(isset($_POST['post_title'])){
				if(!isset($_POST['post_title']) || empty($_POST['post_title'])) $post_error["post_title"] = true;
				if(!isset($_POST['post_content']) || empty($_POST['post_content'])) $post_error["post_content"] = true;
				if(count($post_error) != 0){
					$smarty->assign("post_error", $post_error);
					$smarty->assign("post_data", $_POST);				
				}else{
					$query="	INSERT INTO post (post_content, post_date, post_author, post_title, comment_status) 
								VALUES ('". $_POST['post_content'] ."', 
								'". time() ."', '". $_SESSION['user_id'] ."', 
								'". $_POST['post_title'] ."',
								'". $_POST['comment_status'] ."')";

					$result = $dbconnection->query($query);
					redirect('../?view&id='. $dbconnection->last_insert_id);
				}
			}
		break;
		
		default:
			$smarty->assign("posts", $dbconnection->fetch_array("SELECT * FROM post ORDER BY post_date DESC"));
		break;
	}
		
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display('admin.post.tpl');

?>