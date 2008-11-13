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
					
					
					//start of search engine, not completed yet, please leave the code alone 
					
					// This search engine uses the inverted index method.
					// First we split the text into words, then we check if the word is already in DB and , if necessary, add it along with the post_id,
					// then we build a string with all the ID's, so we can do phrase searching.
					
					//explode on the space so we get each word in an array 
					$words = explode(" ", $_POST['post_content']);
					
					//fetching all the words with their ID's from the DB and putting them into an array 
					$query = "	SELECT *
								FROM search";
								
					$result = $dbconnection->query($query);
					
					while($row = mysql_fetch_array($result)){
						$search_id_words[$row['word']] = $row['post_id'];
						$search_word[] = $row['word'];
						
						
					}
					$id_post = mysql_result($dbconnection->query("SELECT max(post_id) FROM post"), 0);
					
					//now we are going to compare the $words array with the $row array to find the words that are not in the DB
					$tmp = array_diff($words, $search_word);
					foreach($tmp as $word) {
						$query = "INSERT INTO search (word, post_id) VALUES ('$word', '$id_post')";
						$dbconnection->query($query);
					}
					
					//now we are going to find the words that are already in the DB and add the post_id to the word in the DB
					$tmp =  array_flip(array_intersect($words, $search_word));
					$id = array_intersect_key($search_id_words, $tmp);
					
					foreach($id as $key => $word) {
						$final_id .= "". $word .";". $id_post ."";
						$query = "UPDATE search SET post_id = '". $final_id ."' WHERE word = '". $key ."'";
						$dbconnection->query($query);
						unset($final_id);
					}
			
					//end of search engine 
					
					redirect('../?view&id='. $dbconnection->last_insert_id);
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
	}
		
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display('admin.post.tpl');

?>