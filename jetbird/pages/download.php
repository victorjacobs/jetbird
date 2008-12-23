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
	
	require_once "include/uploader.functions.php";
	
	$file_info_query = $dbconnection->query("SELECT * FROM attachment_list WHERE attachment_id = ". $_GET['id']);
	if($dbconnection->num_rows($file_info_query) != 1){
		redirect("./");
	}
	
	$file_info = $dbconnection->fetch_array($file_info_query);
	$file_info = $file_info[0];
	
	// Start teh magic
	header("Cache-Control: public, must-revalidate");
	header("Pragma: hack");
	header("Content-Type: " . $file_info['attachment_type']);
	header("Content-Length: " . $file_info['attachment_size']);
	header('Content-Disposition: attachment; filename="'. $file_info['attachment_original_name'] .'"');
	header("Content-Transfer-Encoding: binary\n");
	
	readfile($config['uploader']['upload_dir'] . $file_info['attachment_file']);

?>