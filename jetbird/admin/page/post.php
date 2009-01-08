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
	//setting magic quotes to avoid intersect problems in indexer
	/*
	 * TODO: add a tag system for easy searching
	 */
	if(!function_exists("redirect")){		// This means that this page hasn't been included right
		die();
	}
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	// Load search functions
	load("search");
	
	switch($action){
		case "edit":
		
			if(empty($_GET['id'])){
				redirect("./");
			}
			if(isset($_POST['submit'])) {
				// This is in here for older posts, which don't have the collumn comment_status yet, can be removed later on
				if(!isset($_POST['comment_status'])){
					$_POST['comment_status'] = "open";
				}
				
				if(!isset($_POST['post_title']) || empty($_POST['post_title'])) $edit_error["post_title"] = true;
				if(!isset($_POST['post_content']) || empty($_POST['post_content'])) $edit_error["post_content"] = true;
				
				if(count($edit_error) != 0){
					$smarty->assign("edit_error", $edit_error);
					$smarty->assign('post_content', $_POST['post_content']);
					$smarty->assign('post_title', $_POST['post_title']);
					$smarty->assign('comment_status', $_POST['comment_status']);
				}else{
					$query = "	UPDATE post 
								SET post_content = '". $_POST['post_content'] ."',
								post_title = '". $_POST['post_title'] ."',
								comment_status = '". $_POST['comment_status'] ."'
								WHERE post_id = ". $_GET['id'];
					$db->query($query);
					redirect("../?view&id=". $_GET['id']);
					die();
				}
			}else{
				$query = "	SELECT post_content, post_id, post_title, comment_status 
							FROM post 
							WHERE post_id =". $_GET['id'];
						
				$result = $db->fetch_array($query);
				
				// Assume there is only one result
				$main['post'] = htmlentities($result[0]["post_content"]);
				$main['title'] = $result[0]['post_title'];
				$main['comment_status'] = $result[0]['comment_status'];
				
				$smarty->assign('post_content', $main['post']);
				$smarty->assign('post_title', $main['title']);
				$smarty->assign('comment_status', $main['comment_status']);
			}
			
		break;
		
		case "new":
		
			if(isset($_POST['submit'])){
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

					$result = $db->query($query);
					
					$created_post_id = $db->last_insert_id;
					
					


					/*
					 * Start of the indexing process.
					 * TODO: add a word count.
					 */
							
					// Setting some vars
					$text = $_POST['post_content'];
					$title = $_POST['post_title'];
					$post_id = $created_post_id;
						
					//splitting text and title into words and some cleanup.
					$text = split_text($text);
					$title = split_text($title);
						
					//make them unique
					$title = array_unique($title);
					$text = array_unique($text);
						
					//query to fetch the id's
					$query = "SELECT * FROM search_index";
					$result = $dbconnection->query($query);
					while($row = mysql_fetch_array($result)) {
						$index[$row['word']] = $row['id'];
					}
						
					//adding title words to search_word
					foreach($title as $word) {
						if(empty($index[$word])) {
							$query = "INSERT INTO search_index (word) VALUES ('". addslashes($word) ."')";
							$dbconnection->query($query);
							$index[$word] = $dbconnection->last_insert_id;
						}
						$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
									VALUES ('$index[$word]', '$post_id', 1)";
						$dbconnection->query($query);
					}
						
					//adding text words to search_word
					foreach($text as $word) {
						if(empty($index[$word])) {
							$query = "INSERT INTO search_index (word) VALUES ('". addslashes($word) ."')";
							$dbconnection->query($query);
							$index[$word] = $dbconnection->last_insert_id;
						}
						$query = "	INSERT INTO search_word(word_id, post_id) 
									VALUES ('$index[$word]', '$post_id')";
						$dbconnection->query($query);
					}	
				}	

				redirect('../?view&id='. $created_post_id);
			}

			
		break;
		
		default:
			$smarty->assign("posts", $db->fetch_array(
				"SELECT *
				FROM post, user
				WHERE post.post_author = user.user_id
				ORDER BY post.post_date DESC
				"));
			// $foo = $db->fetch_array(
			// "	SELECT post. * , user.user_name , COUNT( comment.comment_id ) AS comment_count
			// 	FROM comment LEFT JOIN (
			// 	post, user
			// 	) ON ( user.user_id = post.post_author
			// 	AND comment.comment_parent_post_id = post.post_id ) 
			// 	GROUP BY post.post_id
			// 	ORDER BY post.post_date DESC
			// ");
			
		break;
		
		case "delete":
			if(isset($_POST['submit']) && isset($_POST['id'])){
				if($db->num_rows("SELECT * FROM post WHERE post_id = ". $_POST['id']) == 1){
					$delete_post = "DELETE FROM post WHERE post_id = ". $_POST['id'];
					$delete_comments = "DELETE FROM comment WHERE comment_parent_post_id = ". $_POST['id'];
					$delete_search = "DELETE FROM search_word WHERE post_id = ". $_POST['id'] ."";
					if($db->query($delete_post) && $db->query($delete_comments) && $db->query($delete_search)){
						$success = true;
					}else{
						$success = false;
					}
					
					if($_POST['method'] == "ajax"){		// If delete was requested via ajax
						if($success){
							echo "success";
						}else{
							echo "fail";
						}
						
						die();							// we don't need smarty to show us a template here
					}else{
						redirect("./?post");
					}
				}
			}else{
				$smarty->display("admin.post.tpl");
			}
		break;
	}
		
	$smarty->assign("queries", $db->queries);
	$smarty->display('admin.post.tpl');

?>