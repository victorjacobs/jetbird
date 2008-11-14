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
			
			//split the search term into words
			$search_words = explode(" ", $_POST['search']);
			
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
			
		break;
		
		case "build_index":
			// DO NOT USE YET, IT WORKS, BUT THERE IS SOMETHING WRONG ABOUT THIS SCRIPT, IT SEEMS TO BE STUCK IN A LOOP SOMEHOW.
			//fetching all the posts form the DB.
			$query = "SELECT post_content, post_id FROM post";
			$result = $dbconnection->query($query);
			while($row = mysql_fetch_array($result)) {
				$array_post[$row['post_id']] = $row['post_content'];
			}
			//die(print_r($array_post));
			foreach($array_post as $id_post => $post) {
					
					$words = explode(" ", $post);
					
					//fetching all the words with their ID's from the DB and putting them into an array 
					$query = "	SELECT *
								FROM search";
								
					$result = $dbconnection->query($query);
					
					while($row = mysql_fetch_array($result)){
						$search_id_words[$row['word']] = $row['post_id'];
						$search_word[] = $row['word'];
						
						
					}
					
					
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
			}				
			break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display("search.tpl");
	
?>	
	