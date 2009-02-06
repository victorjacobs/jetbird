<?php
	class search {
		
		function get_word_id($words) {
			global $config;
			global $db;
			
			$index = get_index();
			foreach($words as $word) {
				$word_id[$word] = $index[$word];
			}
			if(empty($word_id)) {
				return false;
			}
			else {
				return $word_id;
			}
		}
		
		function get_index() {
			global $config;
			global $db;
			
			$dbconnection = new database_handler;
			$query = "SELECT * FROM search_index";
			$result = $dbconnection->query($query);
			while($row = mysql_fetch_array($result)) {
				$index[$row['word']] = $row['id'];
			}
			return $index;
		}
		
		function index_title($title, $index, $post_id) {
			global $config;
			global $db;
			
			//cleaning and splitting text
			$title = split_text($title);
			$title = array_unique($title);
			
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
			return true;	
		}
	
	/*
	 * This function indexes text
	 * $index must we in the format of word => id
	 */
		function index_text($text, $index, $post_id) {
			global $config;
			global $db;
			$text = split_text($text);
			$text = array_unique($text);
			
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
			return true;
		}
	
	/*
	 * Returns an array with the post id's that have a title match for the provided word id's
	 * NOTE: these results are not sorted in ANY way, use the process_results if you want a array sorted on importance
	 */
	function search_title($word_id) {
		global $config;
		global $db;
		foreach($word_id as $id) {
			if(empty($sub_query)) {
				$sub_query = " word_id = '". $id ."' AND title_match = 1";
			} 
			else 
			{
				$sub_query .= " OR word_id = '". $id ."' AND title_match = 1";
			}
		}
		$query = "  SELECT * 
					FROM search_word
					WHERE ". $sub_query."";
		$result = $dbconnection->query($query);
		while($row = mysql_fetch_array($result)) {
			$post_id[] = $row['post_id'];
		}
		return $post_id;
	}
	
	/*
	 * Returns an array with the post id's that have a text match for the provided word id's.
	 * NOTE: not sorted, you must use process_results.
	 */
	function search_text($word_id) {
		global $config;
		global $db;
		foreach($word_id as $id) {
			if(empty($sub_query)) {
				$sub_query = " word_id = '". $id ."' AND title_match = 0";
			} 
			else 
			{
				$sub_query .= " OR word_id = '". $id ."' AND title_match = 0";
			}
		}
		$query = "  SELECT * 
					FROM search_word
					WHERE ". $sub_query."";
		$result = $dbconnection->query($query);
		while($row = mysql_fetch_array($result)) {
			$post_id[] = $row['post_id'];
		}
		return $post_id;
	}
	
	
	/*
	 * takes the results of the search_title and search_text and orders them, returns an array with all the post data.
	 */
	function process_results($text, $title) {
		global $config;
		global $db;
		// Sorting title and text on occurence, the more a post_id is in the array (thus more words) the higher it will be ranked in the array.
		$title = array_count_values($title);
		$text = array_count_values($text);
		arsort($title, SORT_NUMERIC);
		arsort($text, SORT_NUMERIC);
		
		//Finding words that are both in the title and the text and put them up front.
	}
	
}
?>