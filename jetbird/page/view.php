<?

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
	
	load('search');
	
	if(!isset($_GET['id'])){
		if(function_exists("redirect")){
			redirect("./");
		}else{
			die();
		}
	}
	
	// Checking all incoming Data of the user to prevent attacks.
	if(!is_numeric($_GET['id'])){
		redirect("./");
	}
	
	
	// Post
	$query = "	SELECT *, (SELECT tag FROM tags WHERE tags.post_id = '". $_GET['id'] ."') AS tags
				FROM post, user
				WHERE post_id = '". $_GET['id'] ."'
				AND user.user_id = post.post_author";			

	$result = $db->query($query);
	
	if($db->num_rows($result) == 1){
		$result = $db->fetch_array($result);
		$smarty->assign("post", $result[0]);
		
		if(isset($_GET['page']) && $_GET['page'] <= 1){		// TODO: protect this with some regex or something
			redirect('./?view&id='. $_GET['id']);
		}
	}else{
		redirect("./");
	}
	
	// Comments
	if(!isset($_GET['page'])){
		$page = 1;
	}else{
		$page = $_GET['page'];
	}
	
	// Figure out what the lower limit is based on the current page and settings in configuration.php
	$pagination_lower_limit = (($page * $config['blog']['view_post_max_comments']) - $config['blog']['view_post_max_comments']);
	
	$total_number_comments = $db->fetch_result("SELECT COUNT(comment_id) FROM comment WHERE comment_parent_post_id = ". $_GET['id']);
	
	if($pagination_lower_limit > $total_number_comments){
		while(($page * $config['blog']['view_post_max_comments']) - $config['blog']['view_post_max_comments'] > $total_number_posts) $page--;
		redirect("./?view&id=". $_GET['id'] ."&page=". $page);
	}

	$query = "SELECT *
		FROM comment
		WHERE comment_parent_post_id = ". $_GET['id'] ."
		ORDER BY comment_id DESC
		LIMIT ". $pagination_lower_limit .", ". $config['blog']['view_post_max_comments'];	

	$comments = $db->fetch_array($query);
	
	if(count($comments) != 0){
		$smarty->assign("comments", $comments);
		
		// Figure out what links to show in template, it's better to do this here than in template, would
		//  be a mess otherwise
		$total_pages = ceil($total_number_comments / $config['blog']['view_post_max_comments']);

		// Prevent weird stuff from happening
		$display_next_link = false;
		$display_prev_link = false;

		if($total_pages != 1){
			if($page > 1){
				$display_next_link = true;
			}
			if($page < $total_pages){
				$display_prev_link = true;
			}
		}

		$smarty->assign("pagination", array("next" => $display_next_link, "prev" => $display_prev_link,
											"page" => $page, "total_pages" => $total_pages));
	}
	
	if(count($_SESSION['comment_error']) != 0){
		$smarty->assign("comment_error", $_SESSION['comment_error']);
		unset($_SESSION['comment_error']);
		
		$smarty->assign("comment_data", $_SESSION['comment_data']);
		unset($_SESSION['comment_data']);
	}
	
	// Getting tags of the post.
	$tags = $db->fetch_array("SELECT tag FROM tags WHERE post_id = ". $_GET['id']);
	
	
	//die(var_dump($tags));
	$smarty->assign('tags', $tags);
	$smarty->assign('queries', $db->queries);	
	$smarty->display('view.tpl');
	

	
?>