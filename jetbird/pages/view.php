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
		
	switch($_GET['action']){
	/*
	/*	view section     
	*/	
		case view_post:
		
		/*
		/*	the main post section, here the main post will be done.    
		*/	
		
			if(!isset($_GET['post_id'])){
				$smarty->assign('view', FALSE);
			}
			
			$query = "SELECT post, title, date
						FROM post
						WHERE post_id = ". $_GET['post_id'] ."";			
			
			$result = $dbconnection->query($query);
			if(mysql_num_rows($result) == 1){
				$row = mysql_fetch_array($result);
				$smarty->assign('view_post', nl2br($row['post']));
				$smarty->assign('view_date', date("D M j G:i  Y", $row['date']));
				$smarty->assign('view_title', $row['title']);
			}else{
				$smarty->assign('view', FALSE);
			}
			
		/*
		/*	the comments sections, here the comments will be done   
		*/
		
			$query = "SELECT comment.comment_parent_id, comment.comment, comment.comment_date,
								users.username, users.user_id, comment.comment_id, comment.pcomment_id
								FROM comment, users
								WHERE comment_parent_id = ". $_GET['post_id'] ."
								AND comment.pcomment_id = users.user_id";
		
			$result = $dbconnection->query($query);
		
			while($row = mysql_fetch_array($result)){
				$view_content['comment'][] = nl2br($row['comment']);
				$view_content['date'][] = date("D M j G:i  Y", $row['comment_date']);
				$view_content['username'][] = $row['username'];
			}
							
			$smarty->assign('comment', $view_content['comment']);
			$smarty->assign('date', $view_content['date']);
			$smarty->assign('username', $view_content['username']);		
		break;
			
		default:
			$smarty->assign('view', FALSE);
	}
		
	$smarty->assign('queries', $dbconnection->queries);	
	$smarty->display('view.tpl');
	
?>