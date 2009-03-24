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
	

	
	switch($_GET['action']) {
		case "search":
			$text = $_POST['search'];						
			$search = new search_class;
			$post = $search->search($text); 
			if (!$post) {
				unset ($post);
			}
			//die(var_dump($post));
			$smarty->assign("results", $post);
		break;
	}
	
	$smarty->assign("queries", $db->queries);
	$smarty->display("search.tpl");
	
?>	
	