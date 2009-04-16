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
			$search = new search_class;

			if (isset($_POST['submit'])) {
				$query = "TRUNCATE search_word";
				$db->query($query);
				$query = 'TRUNCATE search_index';
				$db->query($query);

				$query = "SELECT * FROM post";
				$result = $db->query($query);
				$post = $db->fetch_array($result);
				
				// Indexing text
				foreach($post as $post) {
					$search->index($post['post_content'], $post['post_id'], 1); //indexing text
					$search->index($post['post_title'], $post['post_id'], 2); //indexing title
				}
				
				// Indexing Tags
				$query = "SELECT * FROM tags";
				$result = $db->query($query);
				$tags = $db->fetch_array($result);
				
				foreach($tags as $tag) {
					$search-> index($tag['tag'], $tag['post_id'], 3);
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
		break;
	}
	
	$smarty->display("admin.search.tpl");

?>