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
			
				if(!isset($_POST['main_title']) || empty($_POST['main_title'])) {
				$post_error['title'] = true;
				}
				
					if(!isset($_POST['main_text']) || empty($_POST['main_text'])) {
					$post_error['text'] = true;
				}
				
				if (count($post_error) !=0 ) {
					$_SESSION['post_error'] = $post_error;
					$_SESSION['post_data'] = $_POST;
					redirect("./?post&action=main_make_post", 0);
					
				}
			
				$date = time();
				$query="	INSERT INTO post (post_content, post_date, post_author, post_title) 
							VALUES ('". $_POST['main_text'] ."', 
							'$date', '". $_SESSION['user_id'] ."', 
							'". $_POST['main_title'] ."')";
							
				$result = $dbconnection->query($query);
				redirect('./', 1);
			}	
			
			break;
			
			case main_edit_post:

				if 	(!isset($_POST['post_title'])) {		
					$query = "	SELECT post_content, post_id, post_title, comment_status 
								FROM post 
								WHERE post_id =". $_GET['id'];
							
					$row = $dbconnection->fetch_array($query);
					
					foreach($row as $result) {
						$main['post'] = htmlentities($result['post_content']);
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
				if(isset($_POST['comment'])){
					// Check whether something is inserted in the fields
					if(!isset($_POST['author']) || empty($_POST['author'])) $comment_error["author"] = true;
					if(!isset($_POST['email']) || empty($_POST['email'])){
						$comment_error["author"] = true;
					}elseif(!check_email_address($_POST['email'])){
						$comment_error["email"] = true;
					}
					if(!isset($_POST['comment']) || empty($_POST['comment'])) $comment_error["comment"] = true;
					
					if(isset($_POST['website'])){
						if(!eregi('^(http://)?(www\.)?[a-z0-9_-]+\.([a-z]{2,4})/?', $_POST['website'])){
							// When website url doesn't pass eregi validation, just discard it.
							// TODO: maybe show a little message instead of just discarting it
							unset($_POST['website']);
						}else{
							$start = substr($_POST['website'], 0, 8);
							if(!eregi("http://", $start) && !eregi("https://", $start)){
								$_POST['website'] = "http://". $_POST['website'];
							}
							$_POST['website'] = strtolower($_POST['website']);	// Links are case-insensitive
						}
					}
					
					if(count($comment_error) != 0){
						$_SESSION['comment_error'] = $comment_error;
						$_SESSION['comment_data'] = $_POST;
						redirect("./?view&id=" . $_GET['id'] ."#add_comment");
						die();
					}
					
					$query="	INSERT INTO comment (comment_parent_post_id, comment_author, comment_author_email, comment_author_url, comment_author_ip, comment_date, comment_content, comment_session_id) 
								VALUES ('". $_GET['id'] ."', 
								'". addslashes($_POST['author']) ."', 
								'". addslashes($_POST['email']) ."',
								'". addslashes($_POST['website']) ."',
								'". $_SERVER['REMOTE_ADDR'] ."',
								'". time() ."', 
								'". addslashes($_POST['comment']) ."',
								'". session_id() ."')";
					$result = $dbconnection->query($query);
					redirect("./?view&id=" . $_GET['id'] ."#comments");
				}else{
					redirect("./");		// Just being lame here
				}			
			break;
		}
	$smarty->assign('queries', $dbconnection->queries);
	$smarty->display('post.tpl');
	
?>