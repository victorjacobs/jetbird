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

	$query = "	SELECT post.post_content, post.post_title, 
				post.post_date, user.user_name, post.comment_status
				FROM post, user
				WHERE post_id = ". $_GET['id'] ." 
				AND user.user_id = post.post_author";			

	$result = $dbconnection->query($query);
	
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_array($result);
		$smarty->assign("post", $row);
	}else{
		redirect("./");
	}

	$query = "SELECT comment.comment_content, comment.comment_date,
		comment.comment_id, comment.comment_author
		FROM comment
		WHERE comment_parent_post_id = ". $_GET['id'] ."
		ORDER BY comment_id DESC";
	

	$comments = $dbconnection->fetch_array($query);
	
	if(count($comments) != 0){
		$smarty->assign("comments", $comments);
	}
	
	if(count($_SESSION['comment_error']) != 0){
		$smarty->assign("comment_error", $_SESSION['comment_error']);
		unset($_SESSION['comment_error']);
		
		$smarty->assign("comment_data", $_SESSION['comment_data']);
		unset($_SESSION['comment_data']);
	}

	$smarty->assign('queries', $dbconnection->queries);	
	$smarty->display('view.tpl');
	
?>