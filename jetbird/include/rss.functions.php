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
	
	function generate_rss_feed(){
		global $smarty, $config, $db;
		
		$data = $db->fetch_array("	SELECT *
									FROM post, user
									WHERE post.post_author = user.user_id
									ORDER BY post_date DESC
									LIMIT 0, 20");
		
		// Fetch some data from $config
		$smarty->assign("title", $config['rss']['title']);
		$smarty->assign("link", $config['rss']['link']);
		$smarty->assign("description", $config['rss']['description']);
		$smarty->assign("ttl", $config['rss']['ttl']);
		
		// Some general stuff
		$smarty->assign("pub_date", date("r"));
		$smarty->assign("last_build_date", date("r", $data[0]["post_date"]));
		
		// Loop through data and change some stuff
		foreach($data as $item){
			$rss[$i] = $item;
			$rss[$i]['post_date'] = date("r", $item['post_date']);
			
			$i++;
		}
		
		$smarty->assign("rss", $rss);
		
		return $smarty->fetch_rss("rss2.0.tpl");
	}
	
	function write_rss_feed(){		
		$feed_home = find("feed/");
		
		if(($fh = @fopen($feed_home . "feed.xml", "w")) === false){
			trigger_error("write_rss_feed could not lock file for writing", E_USER_WARNING);
			return false;
		}else{
			fwrite($fh, generate_rss_feed());
			fclose($fh);
			return true;
		}
	}

?>