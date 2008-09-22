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
	
	/*
	/*	header section	      
	*/

	/*
	/*	content/main body section	      
	*/

		/* here we are going to fetch all the data from the DB
		/* and place it in one big array so we can output it to smarty
		*/


		// fetching data out of DB
		$query = "SELECT post.* , users.username 
					FROM post
					INNER JOIN users
					ON post.puser_id = users.user_id
					ORDER BY post.post_id DESC LIMIT 5";	

		$result = $dbconnection->query($query);

		// placing all the data in one array
		while($row = mysql_fetch_array($result)){
			$main_content['title'][] = $row['title'];
			$main_content['date'][] = date("D M j G:i  Y", $row['date']);
			$main_content['post'][] = nl2br(preview_text($row['post'], 500, 1));
			$main_content['post_id'][] = $row['post_id'];
		}

		//output to smarty
		$smarty->assign('main_post', $main_content['post']);
		$smarty->assign('main_title', $main_content['title']);
		$smarty->assign('main_date', $main_content['date']);
		$smarty->assign('post_id', $main_content['post_id']);
		$smarty->assign('queries', $dbconnection->queries);
		$smarty->display('index.tpl');

	/*
	/*	footer section	      
	*/

?>