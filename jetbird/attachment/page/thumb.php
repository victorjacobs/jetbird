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
	
	if(!isset($_GET['id'])){
		redirect("./");
	}
	
	$file_info_query = $db->query("SELECT * FROM attachment_list WHERE attachment_id = ". $_GET['id']);
	if($db->num_rows($file_info_query) != 1){
		redirect("./");
	}
	
	$file_info = $db->fetch_array($file_info_query);
	$file_info = $file_info[0];
	
	// Only some types of file are allowed to be displayed this way:
	if(eregi("image", $file_info['attachment_type'])){
		// Send headers
		header("Cache-Control: public, must-revalidate");
		header("Pragma: hack");
		if(file_exists($config['uploader']['upload_dir'] . $file_info['attachment_file'] . "_thumb")){
			// Thumbs are always image/jpeg
			header("Content-Type: image/jpeg");
		}else{
			header("Content-Type: ". $file_info['attachment_type']);
		}
		header('Content-Disposition: inline; filename="'. $file_info['attachment_original_name'] .'"');
		header("Content-Transfer-Encoding: binary\n");
		
		if(file_exists($config['uploader']['upload_dir'] . $file_info['attachment_file'] . "_thumb")){
			readfile($config['uploader']['upload_dir'] . $file_info['attachment_file'] . "_thumb");
		}else{
			readfile($config['uploader']['upload_dir'] . $file_info['attachment_file']);
		}
	}else{
		redirect("./?download&id=". $_GET['id']);
	}

?>