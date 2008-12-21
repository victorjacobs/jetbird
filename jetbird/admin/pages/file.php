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
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	require_once "../include/uploader.functions.php";
	
	switch($action){
		case "upload":
			$smarty->assign("max_file_size", unformat_size($config['uploader']['max_file_size']));
			
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
																attachment_original_name,
																attachment_type,
																attachment_size,
																attachment_date)
									VALUES (". $filename .",
											". $file['name'] .",
											". $file_type .",
											". $file['size'] .",
											". date() .")";
						if(!$dbconnection->query($query)){		// Destroy file if query doesn't succeed
							unlink($target);
						}else{
							
						}
					}
				}
			}
		break;
		
		default:
			
		break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display("admin.file.tpl");

?>