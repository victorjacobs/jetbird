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
				
			}


			if(empty($_FILES['uploaded_file']['type'])){
				$mime = mime($_FILES['uploaded_file']['name']);
			}else{
				$mime = $_FILES['uploaded_file']['type'];
			}

			$temp_arr = explode("/", $mime);
			$file_type = $temp_arr[0];

			if($config['uploader']['restrict_file_types'] && !in_array($file_type, $config['uploader']['file_types'])){
				$msg = "It's not allowed to upload ";
				$vowels = array("a", "e", "i", "o", "u");
				if(in_array($file_type{0}, $vowels)){
					$msg .= "an";
				}else{
					$msg .= "a";
				}
				$msg .= " ". $file_type ." file!";
				$smarty->upload_err($msg);
				exit();
			}

			// now that everything is fine, move tmp file to proper directory
			$filename = md5(uniqid(rand(), true));
			$target = $config['uploader']['upload_dir'] . $filename;

			if(!move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target)){
				$smarty->upload_err("Something went wrong copying the temporary file (check permissions of the upload directory)");
				exit();
			}

			$now = time();
			$query = 'INSERT INTO uploads (upload_file, upload_orig, upload_type, upload_size, upload_date) VALUES ("'. $filename .'", "'. $_FILES['uploaded_file']['name'] .'", "'. $mime .'", "'. $_FILES['uploaded_file']['size'] .'", "'. $now .'")';
			if(!$dbconnection->query($query)){
				$smarty->upload_err("Could not query the database: \"". mysql_error($dbconnection->link_identifier) ."\", removing file...");
				unlink($target);
				exit();
			}

			if(!empty($config['uploader']['pseudo_root'])){
				$base_uri = $config['uploader']['pseudo_root'];
			}else{
				$base_uri = "http://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['PHP_SELF']), "", $_SERVER['PHP_SELF']);
			}

			$smarty->assign("download_link", $base_uri . "?download&amp;id=". $dbconnection->last_insert_id);
			if(eregi("image", $file_type) || eregi("video", $file_type) || eregi("text", $file_type) || eregi("audio", $file_type)){
				$smarty->assign("view_link", $base_uri . '?view&amp;id='. $dbconnection->last_insert_id);
			}
		break;
		
		default:
			
		break;
	}
	
	$smarty->assign("queries", $dbconnection->queries);
	$smarty->display("admin.file.tpl");

?>