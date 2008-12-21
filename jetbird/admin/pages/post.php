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
					 * Start of the indexing process.
					 * TODO: add a word count.
					 * TODO: find a way to avoid using so much array intersects.
					 * TODO: get rid of the if(empty($index)) loop.
					 */
						
						// Setting some vars
						$text = $_POST['post_content'];
						$title = $_POST['post_title'];
						$post_id = $created_post_id;
						
						//splitting text and title into words and some cleanup.
						$keyword_text = split_text($text);
						$keyword_title = split_text($title);
						//make them unique
						$keyword_uniq_title = array_unique($keyword_title);
						$keyword_uniq_text = array_unique($keyword_text);
						//merge them
						$keyword_uniq_all = array_unique(array_merge($keyword_uniq_text, $keyword_uniq_title));
						
						//fetching the search_index from the DB and put it in a nice array
						$query = "SELECT * FROM search_index";
						$result = $dbconnection->query($query);
						
						while($row = mysql_fetch_array($result)) {
							$index[$row['id']] = $row['word'];
						}
						//die(var_dump($index));
						//if $index is empty, we have an empty search table, so we have to do things a bit different.
						/*
						if (empty($index)) {
						
							/*
							 * Building the index.
							 */
						/*						
								foreach ($keyword_uniq_all as $word) {
									$query = "INSERT INTO search_index (word) VALUES ('$word')";
									$dbconnection->query($query);
								}
							
							/*
							 * Building the search_word table.
							 */
						
							//Now we have a index, we can use it to build our search_word table
							//We need to preserve our id's, so we are going to assign the words as the key,
							//and the id as the value, with the right intersect we can determine the ID for each word.
								
								
							/*	
								$query = "SELECT * FROM search_index";
								$result = $dbconnection->query($query);								
								while($row = mysql_fetch_array($result)) {
									$index[$row['word']] = $row['id'];
								}
								
								$keyword_title_flip = array_flip($keyword_uniq_title);
								$word_id_title = array_intersect_key($index, $keyword_title_flip);																
								foreach($word_id_title as $word_id) {
									//because array_intersect_key makes an array that starts at zero,
									//and the DB's ID index starts at one,
									//this is the easiest way to solve this (i think)
									$word_id = $word_id + 1;
									$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
												VALUES ('$word_id', '$post_id', 1)";
									$dbconnection->query($query);
								}
								
								$keyword_text_flip = array_flip($keyword_uniq_text);
								$word_id_text = array_intersect_key($index, $keyword_text_flip);
								foreach($word_id_text as $word_id) {
									$word_id = $word_id + 1;
									$query = "	INSERT INTO search_word(word_id, post_id) 
												VALUES ('$word_id', '$post_id')";
									$dbconnection->query($query);
								}
								
								
								
							redirect('../?view&id='. $created_post_id);
							break;
							}
*/
					//now the real work can start
					
					/*
					 * Updating the index table
					 */
							//We have to check wich words are already in the DB
							if(empty($index)){
								$new_words = $keyword_uniq_all;
							} else {
							$new_words = array_diff($keyword_uniq_all, $index);
							}
							
							foreach ($new_words as $word) {
								$query = "INSERT INTO search_index (word) VALUES ('$word')";
								$dbconnection->query($query);
							}
							
							if(empty($index)) {
								$query = "SELECT * FROM search_index";
								$result = $dbconnection->query($query);
							
								while($row = mysql_fetch_array($result)) {
									$index[$row['id']] = $row['word'];
								}
							}
							
						
					/*
					 * Updating the search_word table
					 */
							$word_id_all = array_flip(array_merge($index, $new_words));
							
							//now we should have all the word_id's with the keys as our ID
							
							//title
							$keyword_title_flip = array_flip($keyword_uniq_title);
							$word_id_title = array_intersect_key($word_id_all, $keyword_title_flip);
							
							foreach($word_id_title as $word_id) {
								$word_id = $word_id + 1;
								$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
											VALUES ('$word_id', '$post_id', 1)";
								$dbconnection->query($query);
							}
							
							//text
								$keyword_text_flip = array_flip($keyword_uniq_text);
								$word_id_text = array_intersect_key($word_id_all, $keyword_text_flip);
								foreach($word_id_text as $word_id) {
									$word_id = $word_id + 1;
									$query = "	INSERT INTO search_word(word_id, post_id) 
												VALUES ('$word_id', '$post_id')";
									$dbconnection->query($query);
								}
				}
							
					redirect('../?view&id='. $created_post_id);
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