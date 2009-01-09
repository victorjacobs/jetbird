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
	
	if(!function_exists("redirect")){		// This means that this page hasn't been included right
		die();
	}
	
	switch($action){
		
		case "edit_comment":
			if(isset($_POST['ajax'])){
				if(empty($_POST['id'])){
					die("no_id");
				}
				
				// Get info
				$comment_info = $db->fetch_array("SELECT * FROM comment WHERE comment_id = ". $_POST['id']);
				
				if($_SESSION['logged_in'] || $comment_info['comment_session_id'] == session_id()){
					// This form doesn't need smarty, cause it's standard:
					echo '
						<form method="post" action="./?post&amp;edit_comment&amp;id=">
						<textarea name="content">'. $comment_info['comment_content'] .'</textarea>
						</form>';
				}
			}
		break;
		
		case "comment":			
			if(isset($_POST['submit'])){
				// Check whether something is inserted in the fields
				if(!isset($_POST['author']) || empty($_POST['author'])) $comment_error["author"] = true;
				if(!isset($_POST['email']) || empty($_POST['email'])){
					$comment_error["email"] = true;
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
				$result = $db->query($query);
				redirect("./?view&id=" . $_GET['id'] ."#comments");
			}else{
				redirect("./");		// Just being lame here
			}					
		break;
		
		default:
			if(function_exists("redirect")){
				redirect("./");
			}else{
				die();
			}
		break;
	}
	
?>