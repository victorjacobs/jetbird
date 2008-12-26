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
	
	require_once "../include/uploader.functions.php";
	
	// Find attachment directory, since $config gives us a path relative to jetbird's root
	// NOTE: Need to find out how this code behaves on windows hosts
	if($config['uploader']['upload_dir']{0} == "/"){
		$config['uploader']['upload_dir'] = "..". $config['uploader']['upload_dir'];
	}else{
		$config['uploader']['upload_dir'] = "../". $config['uploader']['upload_dir'];
	}
	
	switch($action){
		case "upload":
			$smarty->assign("max_file_size", unformat_size($config['uploader']['max_file_size']));
			
			if(!file_exists($config['uploader']['upload_dir']) || !is_writable($config['uploader']['upload_dir'])){
				$smarty->assign("error_message", "Upload directory doesn't exist, or isn't writable.");
				$upload_error['upload_dir_corrupt'] = true;
			}
			
			// sanity checks
			if(isset($_POST['upload'])){
				// Let's make our life easier by assigning our file to a shorter var
				$file = &$_FILES['uploaded_file'];
				
				if(!isset($file['name']) || empty($file['name'])) $upload_error['no_file_uploaded'] = true;
				if(!is_uploaded_file($file['tmp_name'])) $upload_error['invalid_upload'] = true;
				if($file['size'] <= 0) $upload_error['invalid_upload'] = true;
				if($file['size'] > unformat_size($config['uploader']['max_file_size'])) $upload_error['file_too_big'] = true;
								
				if(count($upload_error) == 0){
					if(empty($_FILES['uploaded_file']['type'])){
						$mime = mime($_FILES['uploaded_file']['name']);
					}else{
						$mime = $_FILES['uploaded_file']['type'];
					}
					
					list($file_type, ) = explode("/", $mime);
					
					$filename = md5(uniqid(rand(), true));
					
					$target = $config['uploader']['upload_dir'] . $filename;
					
					if(move_uploaded_file($file['tmp_name'], $target)){
						$query = "INSERT INTO attachment_list(	attachment_file,
																attachment_owner,
																attachment_original_name,
																attachment_type,
																attachment_size,
																attachment_date)
									VALUES ('". $filename ."',
											". $_SESSION['user_id'] .",
											'". $file['name'] ."',
											'". $mime ."',
											". $file['size'] .",
											". time() .")";
						
						if(!$dbconnection->query($query)){		// Destroy file if query doesn't succeed
							unlink($target);
						}else{
							$download_link = jetbird_root_url() . "?download&amp;id=". $dbconnection->last_insert_id;
							$smarty->assign("download_link", $download_link);
							$smarty->assign("success", true);
						}
						
						if($file_type = "image"){
							// Resize images here
						}
					}
				}else{
					$smarty->assign("upload_error", $upload_error);
				}
			}
		break;
		
		case "delete":
		
			if(isset($_POST['submit']) && isset($_POST['id'])){
				$file_query = $dbconnection->query("SELECT * FROM attachment_list WHERE attachment_id = ". $_POST['id']);
				
				if($dbconnection->num_rows($file_query) == 1){
					$file_info = $dbconnection->fetch_array($file_query);
					
					$query = "DELETE FROM attachment_list WHERE attachment_id = ". $_POST['id'];
					if($dbconnection->query($query) &&
								@unlink($config['uploader']['upload_dir'] . $file_info[0]['attachment_file'])){
						$success = true;
					}else{
						$success = false;
					}
					
					if($_POST['method'] == "ajax"){		// If delete was requested via ajax
						if($success){
							echo "success";
						}else{
							echo "fail";
						}
						
						die();							// we don't need smarty to show us a template here
					}else{
						redirect("./?file");
					}
				}
			}else{
				$smarty->display("admin.file.tpl");
			}
		
		break;
		
		default:
			$query = "SELECT attachment_list.*, user.user_name
						FROM attachment_list, user
						WHERE user.user_id = attachment_list.attachment_owner
						ORDER BY attachment_date DESC";
			$smarty->assign("attachments", $dbconnection->fetch_array($query));
		break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display("admin.file.tpl");

?>