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
		$query = "SELECT post.* , user.user_name 
					FROM post, user
					WHERE post.post_author = user.user_id
					ORDER BY post.post_date DESC";	

		$posts = $dbconnection->fetch_array($query);

		$smarty->assign("posts", $posts);
		
		$smarty->display('index.tpl');

	/*
	/*	footer section	      
	*/

?>