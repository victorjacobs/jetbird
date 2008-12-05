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
	
	switch($_GET['action']) {
	
		case "search":
			//setting some vars
			$search = $_POST['search'];
			//split the search term into words
			$search_word = split_text($search);
			
			//getting id's of each word
			foreach($search_word as $word) {
			$query = "	SELECT id 
						FROM search_index
						WHERE word = '". $word ."'";
			}
			
			/*
			 * this is the part were it gets hard.
			 */
			//building the query.
			/*
			foreach($search_word as $word) {
			$q_app .= "";
			}
			/*
			//query the DB to find the posts where the word is
			foreach($search_words as $word) {
				$query = "SELECT post_id FROM search WHERE word = '". $word . "'";
				$result = @mysql_result($dbconnection->query($query), 0);
				
				if($result === false){
					break;
				}
				
				// split the result on ";" to get the post_id's
				$post_id = explode(";", $result);
				foreach($post_id as $id){
					//fetching the posts from the DB
					$query = "SELECT post.*, user.user_name FROM post, user WHERE post_id=". $id ." AND post.post_author = user.user_id";
					
					$result = $dbconnection->fetch_array($query);
					$post[] = $result[0]; //building a array with all the posts
				}
			}
			$smarty->assign("results", $post);
*/
			
		break;
		
		case "repair_search":
			
			//fetching all the posts form the DB.
			$query = "SELECT post_content, post_id, post_title FROM post";
			$result = $dbconnection->query($query);
			while($row = mysql_fetch_array($result)) {
				$array_post[$row['post_id']] = $row['post_content'];
				$title[] = $row['post_title'];
			}
			
			foreach($array_post as $post_id => $text) {
				foreach($title as $title_P) {
			// Setting some vars
			
			/*
						$text = $_POST['post_content'];
						$title = $_POST['post_title'];
						$post_id = $created_post_id;

			*/			
						$title = $title_P;
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
						
						//if $index is empty, we have an empty search table, so we have to do things a bit different.
						if (empty($index)) {
						
							/*
							 * Building the index.
							 */
													
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
								
								
								
								$query = "SELECT * FROM search_index";
								$result = $dbconnection->query($query);								
								while($row = mysql_fetch_array($result)) {
									$index[$row['word']] = $row['id'];
								}
								
								$keyword_title_flip = array_flip($keyword_uniq_title);
								$word_id_title = array_intersect_key($index, $keyword_title_flip);																
								foreach($word_id_title as $word_id) {
									
									$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
												VALUES ('$word_id', '$post_id', 1)";
									$dbconnection->query($query);
								}
								
								$keyword_text_flip = array_flip($keyword_uniq_text);
								$word_id_text = array_intersect_key($index, $keyword_text_flip);
								foreach($word_id_text as $word_id) {
									$query = "	INSERT INTO search_word(word_id, post_id) 
												VALUES ('$word_id', '$post_id')";
									$dbconnection->query($query);
								}
								
						
								
							redirect('../?view&id='. $created_post_id);
							break;
							}
					//now the real work can start
					
					/*
					 * Updating the index table
					 */
							//We have to check wich words are already in the DB
							
							$new_words = array_diff($keyword_uniq_all, $index);
							
							foreach ($new_words as $word) {
								$query = "INSERT INTO search_index (word) VALUES ('$word')";
								$dbconnection->query($query);
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
								$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
											VALUES ('$word_id', '$post_id', 1)";
								$dbconnection->query($query);
							}
							
							//text
								$keyword_text_flip = array_flip($keyword_uniq_text);
								$word_id_text = array_intersect_key($word_id_all, $keyword_text_flip);
								foreach($word_id_text as $word_id) {
									$query = "	INSERT INTO search_word(word_id, post_id) 
												VALUES ('$word_id', '$post_id')";
									$dbconnection->query($query);
								}
				}
			}
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display("search.tpl");
	
?>	
	