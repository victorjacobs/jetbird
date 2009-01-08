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
	
	if(isset($_GET['page']) && $_GET['page'] <= 1){		// TODO: protect this with some regex or something
		redirect('./');
	}
	
	if(!isset($_GET['page'])){
		$page = 1;
	}else{
		$page = $_GET['page'];
	}
	
	// Figure out what the lower limit is based on the current page and settings in configuration.php
	$pagination_lower_limit = (($page * $config['blog']['landing_page_max_posts']) - $config['blog']['landing_page_max_posts']);
	
	$total_number_posts = $db->fetch_result("SELECT COUNT(post_id) FROM post");
	
	if($pagination_lower_limit > $total_number_posts){
		while(($page * $config['blog']['landing_page_max_posts']) - $config['blog']['landing_page_max_posts'] > $total_number_posts) $page--;
		redirect("./?page=". $page);
	}
	
	// Fetching data from DB, limiting results for pagination
	$query = "SELECT post.* , user.user_name 
				FROM post, user
				WHERE post.post_author = user.user_id
				ORDER BY post.post_date DESC
				LIMIT ". $pagination_lower_limit .", ". $config['blog']['landing_page_max_posts'];	
	
	// Figure out what links to show in template, it's better to do this here than in template, would
	//  be a mess otherwise
	$total_pages = ceil($total_number_posts / $config['blog']['landing_page_max_posts']);
	
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
	
	$posts = $db->fetch_array($query);
	
	$smarty->assign("posts", $posts);
	$smarty->assign("queries", $db->queries);
	
	$smarty->display('index.tpl');

?>