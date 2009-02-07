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
	
	error_reporting(8192);		// DEBUG
	
	if(!function_exists("redirect")){		// This means that this page hasn't been included right
		die();
	}
	
	if(!$_SESSION['login'] || $_SESSION['user_level'] ==! 1){
		die();
	}
	
	load("file");
	
	if(unformat_size($config['uploader']['max_file_size']) > unformat_size(ini_get('upload_max_filesize'))){
		// Just throw an ugly warning here:
		trigger_error("max_file_size is bigger than PHP allows us (". format_size(unformat_size(ini_get('upload_max_filesize'))) .")", E_USER_WARNING);
		$config['uploader']['max_file_size'] = ini_get('upload_max_filesize');
	}
	
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
					if(empty($file['type']) && read_mime($file['tmp_name']) !== false){
						$mime = read_mime($file['tmp_name']);
					}elseif($file['type'] != read_mime($file['tmp_name']) && read_mime($file['tmp_name']) !== false){
						unlink($file['tmp_name']);
						die("Type mismatch! PHP reports: <b>". $file['type'] ."</b> real type is: <b>". read_mime($file['tmp_name']) ."</b> <br /> Deleting file... (to protect Jetbird)");
					}else{
						$mime = $file['type'];
					}
					
					list($file_type, $exact_type) = explode("/", $mime);
					
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
						
						if(!$db->query($query)){		// Destroy file if query doesn't succeed
							unlink($target);
						}else{
							$download_link = jetbird_root_url() . "attachment/?download&amp;id=". $db->last_insert_id;
							$smarty->assign("download_link", $download_link);
							$smarty->assign("success", true);
						}
												
						/*	------------------
						*	Thumbnail creation
						*	NOTE: only gif, png and jpeg are supported by GD
						*	------------------
						*/
						
						// Find out GD capabilities
						if(function_exists("imageCreate")){
							define("_JB_GD_INSTALLED", true);
							
							/*	Note on shorthands:
							*	($foo == "bar") ? true : false
							*/
							define("_JB_GD_GIF", (imagetypes() & IMG_GIF) ? true : false);
							define("_JB_GD_PNG", (imagetypes() & IMG_PNG) ? true : false);
							define("_JB_GD_JPEG", (imagetypes() & IMG_JPG) ? true : false);
							
						}else{
							define("_JB_GD_INSTALLED", false);
						}
						
						if(_JB_GD_INSTALLED && $file_type = "image"){
							if($exact_type != "gif" && $exact_type != "png" && $exact_type != "jpeg") break;
							
							if($exact_type == "gif" && !_JB_GD_GIF) break;
							if($exact_type == "png" && !_JB_GD_PNG) break;
							if($exact_type == "jpeg" && !_JB_GD_JPG) break;
							
							// For now just hardcode target size
							$target_w = 200;
							$target_h = 200;
							
							// Load up the original and get size
							//  NOTE: use imageCreateFromString to avoid to check what type of image it is
							$original = imageCreateFromString(file_get_contents($target));
							$original_w = imagesX($original);
							$original_h = imagesY($original);
							
							// Only if the image is really too big, resize it
							// NOTE: if image is smaller than target size, don't do anything.
							//  We *could* copy the original to filename_thumb, but since it's the same
							//  it would be a waste of precious resources
							if($original_w > $target_w || $original_h > $target_h){
								// If original is wider than it's high, resize the width and vice versa
								// NOTE: '>=' cause otherwise it's possible that $scale isn't computed
								if($original_w >= $original_h){
									$scaled_w = $target_w;
									// Figure out how much smaller that target is than original
									//  and apply it to height
									$scale = $target_w / $original_w;
									$scaled_h = $original_h * $scale;
								}elseif($original_w <= $original_h){
									$scaled_h = $target_h;
									$scale = $target_h / $original_h;
									$scaled_w = $original_w * $scale;
								}
							}else{
								// Break out of if($file_type = image) since no resize is needed
								break;
							}
							
							// Scale the image
							$scaled = imageCreateTrueColor($scaled_w, $scaled_h);
							imageCopyResampled($scaled, $original,
							                   0, 0, /* dst (x,y) */
							                   0, 0, /* src (x,y) */
							                   $scaled_w, $scaled_h,
							                   $original_w, $original_h);
							
							$target = $config['uploader']['upload_dir'] . $filename ."_thumb";
							
							// Store thumbs in jpeg, hope no one minds the 100% quality lol
							imageJpeg($scaled, $target, 100);
							
							// Let's be nice to our server
							imagedestroy($scaled);
							imagedestroy($original);
						}
					}
				}else{
					$smarty->assign("upload_error", $upload_error);
				}
			}
		break;
		
		case "regen_thumbs":
			echo "We'll regenerate thumbs here";
			die();
		break;
		
		case "delete":
		
			if(isset($_POST['submit']) && isset($_POST['id'])){
				$file_query = $db->query("SELECT * FROM attachment_list WHERE attachment_id = ". $_POST['id']);
				
				if($db->num_rows($file_query) == 1){
					$file_info = $db->fetch_array($file_query);
					$target = $config['uploader']['upload_dir'] . $file_info[0]['attachment_file'];
					
					$query = "DELETE FROM attachment_list WHERE attachment_id = ". $_POST['id'];
					if($db->query($query) && @unlink($target)){
						if(file_exists($target . "_thumb")){
							if(@unlink($target . "_thumb")){
								$success = true;
							}
						}else{
							$success = true;
						}
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
			$smarty->assign("attachments", $db->fetch_array($query));
		break;
	}
	
	$smarty->assign("queries", $db->queries);
	$smarty->display("admin.file.tpl");

?>