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
	
	$query = "	SELECT *
				FROM post, user
				WHERE post.post_author = user.user_id
				ORDER BY post_date DESC";
	
	$rss_main = $db->fetch_array($query);
	
	$rss['lastbuild'] = date("D, d M y H:i:s", $db->fetch_result("SELECT MAX(post_date) FROM post")) . " ". $config['global']['timezone'];
	
	//$rss['data'] = $rss_main;
	$i = 0;
	foreach($rss_main as $item){
		$rss['data'][$i] = $item;
		$rss['data'][$i]['post_date'] = date("D, d M y H:i:s", $rss['data'][$i]['post_date']) ." ". $config['global']['timezone'];
		$rss['data'][$i]['description'] = truncate($item['post_content'], 200);
		$i++;
	}
	
	$smarty->assign("config", $config['rss']);
	$smarty->assign("rss", $rss);
	$smarty->display_rss("rss2.0.tpl");

?>