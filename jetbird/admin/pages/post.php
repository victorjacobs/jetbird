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

					$result = $dbconnection->query($query);
					
					$created_post_id = $dbconnection->last_insert_id;
					
					
					/*
					 * Start of the indexing process
					 */
					
						// Setting some vars
						$text = $_POST['post_content'];
						$title = $_POST['post_title'];
						$post_id = $created_post_id;
						
						//splitting text into words and some cleanup.
						$keyword = split_text($text);
						
						//fetching the search_index from the DB and put it in a nice array
						$query = "SELECT * FROM search_index";
						$result = $dbconnection->query($query);
						
						while($row = mysql_fetch_array($result)) {
							$index[$row['id']] = $row['word'];
						}
						
						//if $index is empty, we have empty search table, so we can directly import all the records.
						if (empty($index)) { 
							//remove all double words, we only want each word 1 time in our index.
							$keyword_uniq = array_unique($keyword);
							foreach($keyword_uniq as $word) {
								//adding word to the search_index
								$query = "INSERT INTO search_index (word) VALUES ('$word')";
								$dbconnection->query($query);
								$word_id = $dbconnection->last_insert_id;
								//adding word to the search_word
								$query = "INSERT INTO search_word(word_id, post_id) VALUES ('$word_id', '$post_id')";
								$dbconnection->query($query);
							}
							
							
							/*
							//Now we can get properly the id for each word, as we just added them to the DB.
							$query = "SELECT * FROM search_index";
							$result = $dbconnection->query($query);
							
							while($row = mysql_fetch_array($result)){
								$index[$row['word']] = $row['id'];
							}
							
							$keyword_flip = array_flip($keyword);
							//we will lose come words here with the array_intersect_key because it discards double keys,
							//but this is not a problem because we only need one mention to the post in search_word
							
							$word_id = array_intersect_key($index, $keyword_flip);
							die(print_r($word_id));
							
							*/
							$process_end = timer();
							$time = $process_end - $process_start;
							die($time);
							
						redirect('../?view&id='. $created_post_id);
						break;
						
						}
					
					
					redirect('../?view&id='. $created_post_id);
				}
			}
		break;
		
		default:
			$smarty->assign("posts", $dbconnection->fetch_array(
				"SELECT *
				FROM post, user
				WHERE post.post_author = user.user_id
				ORDER BY post.post_date DESC
				"));
			// $foo = $dbconnection->fetch_array(
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
				if($dbconnection->num_rows("SELECT * FROM post WHERE post_id = ". $_POST['id'])){
					$query = "DELETE FROM post WHERE post_id = ". $_POST['id'];					
					if($dbconnection->query($query)){
						echo "success";
					}else{
						echo "fail";
					}
				}
			}
			
			die();	// we don't need smarty to show us a template here
		break;
	}
		
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display('admin.post.tpl');

?>