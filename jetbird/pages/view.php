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

	/*
	/*	the main post section, here the main post will be done.    
	*/	

	

	$query = "	SELECT post.post_content, post.post_title, 
				post.post_date, user.user_name, post.comment_status
				FROM post, user
				WHERE post_id = ". $_GET['id'] ." 
				AND user.user_id = post.post_author";			

	$result = $dbconnection->query($query);
	
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_array($result);
		$text = BBCode($row['post_content']);
		$smarty->assign('view_post', nl2br($text));
		$smarty->assign('view_date', date($config['global']['timestamp'], $row['post_date']));
		$smarty->assign('view_title', $row['post_title']);
		$smarty->assign('author', $row['user_name']);
		$smarty->assign('comment_status', $row['comment_status']);
	}else{
		redirect("./");
	}

	/*
	/*	the comments sections, here the comments will be done   
	*/

	$query = "SELECT comment.comment_content, comment.comment_date,
		comment.comment_id, comment.comment_author
		FROM comment
		WHERE comment_parent_post_id = ". $_GET['id'] ."
		ORDER BY comment_id DESC";
	

	$comments = $dbconnection->fetch_array($query);
	
	if(count($comments) != 0){
		foreach($comments as $comment){
			$text = BBCode($comment['comment_content']);
			$view_content['comment'][] = nl2br($text);
			$view_content['date'][] = date($config['global']['timestamp'], $comment['comment_date']);
			$view_content['username'][] = $comment['comment_author'];
		}
	}
	
	if(count($_SESSION['comment_error']) != 0){
		$smarty->assign("comment_error", $_SESSION['comment_error']);
		unset($_SESSION['comment_error']);
		
		$smarty->assign("comment_data", $_SESSION['comment_data']);
		unset($_SESSION['comment_data']);
	}

	$smarty->assign('comment', $view_content['comment']);
	$smarty->assign('date', $view_content['date']);
	$smarty->assign('username', $view_content['username']);		


	$smarty->assign('queries', $dbconnection->queries);	
	$smarty->display('view.tpl');
	
?>