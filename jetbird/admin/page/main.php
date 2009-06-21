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
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	$comments = $db->fetch_array(
	"	SELECT comment.*, post.post_title
		FROM comment, post
		WHERE comment.comment_parent_post_id = post.post_id
		ORDER BY comment_id DESC
		LIMIT 10
	");
	$smarty->assign("comments", $comments);
	
	$smarty->assign("queries", $db->queries);
	$smarty->display('index.tpl');
	
?>