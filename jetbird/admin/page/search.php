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
	
	load("search");
	
	switch($action){
		case "reindex":
			if (isset($_POST['submit'])) {
				$db->query("TRUNCATE search_word");
				$db->query("TRUNCATE search_index");

				$post = $db->fetch_array("SELECT * FROM post");
				
				// Indexing text
				foreach($post as $post) {
					search::add_to_index($post['post_content'], $post['post_id'], search::WEIGHT_POST); //indexing text
					search::add_to_index($post['post_title'], $post['post_id'], serach::WEIGHT_TITLE); //indexing title
				}
				
				// Indexing Tags
				$tags = $db->fetch_array("SELECT * FROM tags");
				
				foreach($tags as $tag) {
					search::add_to_index($tag['tag'], $tag['post_id'], search::WEIGHT_TAG);
				}
				if($_POST['method'] == "ajax"){
					echo "success";
					die();
				}

				$smarty->assign('ask', false);
			} else {
				$smarty->assign('ask', true);
			}
		break;
		
		default:
			$smarty->assign("ask", true);
			
			$stats['total_words'] = $db->num_rows("SELECT * FROM search_word");
			
			$smarty->assign("stats", $stats);
		break;
	}
	
	$smarty->display("search.tpl");

?>