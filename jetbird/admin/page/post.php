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
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	// Load search functions
	load("search");
	load("rss");
	
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
					// The input that we recieved has gone through the BBCode function, and thus has html entities, so we should decode them.
					// we should write our own function for this, but now i'm a bit lazy.
					$post_content = html_entity_decode($_POST['post_content'], UTF-8);
			
					$query = "	UPDATE post 
								SET post_content = '". $post_content ."',
								post_title = '". $_POST['post_title'] ."',
								comment_status = '". $_POST['comment_status'] ."'
								WHERE post_id = ". $_GET['id'];
					$db->query($query);

					
					//Updating the index of the search engine.
					$search = new search_class;
					$search->delete_from_index($_GET['id']);
					$search->index($post_content, $_GET['id'], 1); //post
					$search->index($_POST['post_title'], $_GET['id'], 2); //title	
					write_rss_feed();
					redirect("../?view&id=". $_GET['id']);
					die();
				}
			}else{
				$query = "	SELECT post_content, post_id, post_title, comment_status 
							FROM post 
							WHERE post_id =". $_GET['id'];
						
				$result = $db->fetch_array($query);
				
				// Assume there is only one result
				$main['post'] = htmlspecialchars($result[0]["post_content"]);
				$main['title'] = $result[0]['post_title'];
				$main['comment_status'] = $result[0]['comment_status'];
				
				$smarty->assign('post_content', $main['post']);
				$smarty->assign('post_title', $main['title']);
				$smarty->assign('comment_status', $main['comment_status']);
			}
			
		break;
		
		case "new":
		
			if(isset($_POST['submit'])){
				//TODO add checks for the tag thingie.
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
					 */
							
					// Setting some vars
					$text = $_POST['post_content'];
					$title = $_POST['post_title'];
					$post_id = $created_post_id;
					$tags = $_POST['post_tags'];
					//indexing the text
					
					$search = new search_class;
					$search->index($text, $post_id, 1); //indexing text.
					$search->index($title, $post_id, 2); //indexing title.
					$search->index($tags, $post_id, 3); // indexing tags.
					write_rss_feed();
					
					
					//updating tags table.
					$tags = $search->split_text($tags);
					foreach ($tags as $tag) {
						$query = "INSERT INTO tags (post_id, tag) VALUES ($post_id, '$tag')";
						$db->query($query);					
					}
				redirect('../?view&id='. $created_post_id);
			}

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
					$search = new search_class;
					$search->delete_from_index($_POST['id']);
					
					if($db->query($delete_post) && $db->query($delete_comments) && $db->query($delete_search)){
						$success = true;
						write_rss_feed();
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