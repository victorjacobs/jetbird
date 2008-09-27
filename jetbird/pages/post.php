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
		
	switch($_GET['action']) {
	/*
	/*	main post section    
	*/		
			case main_make_post:
			
			if(isset($_POST['main_title'])) {
				$date = time();

				
				$query="	INSERT INTO post (post_content, post_date, post_author, post_title) 
							VALUES ('". $_POST['main_text'] ."', '$date', '". $_SESSION['user_id'] ."', '". $_POST['main_title'] ."')";
				
				$result = $dbconnection->query($query);
				redirect('./', 2);
			}	
			
			break;
			
			case main_edit_post:

				if 	(!isset($_POST['post_title'])) {		
					$query = "	SELECT post_content, post_id, post_title, comment_status 
								FROM post 
								WHERE post_id =". $_GET['post_id'];
							
					$row = $dbconnection->fetch_array($query);
					
					foreach($row as $result) {
						$main['post'] = $result['post_content'];
						$main['title'] = $result['post_title'];
						$main['comment_status'] = $result['comment_status'];
					}
					
					$smarty->assign('post_text', $main['post']);
					$smarty->assign('post_title', $main['title']);
					$smarty->assign('comment_status', $main['comment_status']);				
				}
											
				// Section to post the modified text
				if(isset($_POST['post_title'])) {
					if(!isset($_POST['comment_status'])){
						$_POST['comment_status'] = "open";
					}					
					$query = "	UPDATE post 
								SET post_content = '". $_POST['post_text'] ."',
								post_title = '". $_POST['post_title'] ."',
								comment_status = '". $_POST['comment_status'] ."'
								WHERE post_id = '". $_GET['id'] ."' LIMIT 1";
								
					$dbconnection->query($query);
				
					redirect("./", 0);
				}
				
			break;
			case make_comment:			
				if (isset($_POST['comments_text'])) {
					$date = time();
					$query="	INSERT INTO comment (comment_parent_post_id, comment_content, comment_author, comment_date) 
								VALUES ('". $_GET['id'] ."', '". $_POST['comment'] ."', '". $_POST['author'] ."', '$date')";
					$result = $dbconnection->query($query);
					redirect("./?view&id=" . $_GET['id']);
					die();
				}				
			break;
		}
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display('post.tpl');
	
?>