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

	//fetching the required data out of the DB
	
		$query = "	SELECT post_content, post_title, post_id 
					FROM post
					ORDER BY post_id DESC LIMIT 0,10";
		
		$dbconnection->query($query);
		
		//making the main URL, a function should be made for this.
		$main_url = substr($config['current_url'], 0, -4);
		
		//opening the file for reading
		$file = fopen("rss.xml", "w");
		
		//static piece of the RSS feed
		$xml = "<?xml version='1.0' encoding='ISO-8859-1' ?>\n";
		$xml .= "<rss version='2.0'>\n";
		$xml .= "<channel>\n";
		$xml .= "<title>Jetbird preview RSS</title>\n";
		$xml .= "<link>". $main_url ."</link>\n";
		$xml .= "<description> Jetbird </description>\n";
		
		//dynamic piece of the RSS feed
		$result = $dbconnection->fetch_array($query);
		foreach($result as $rss) {
		$xml .= "<item>\n";
		$xml .= "<title>". $rss[post_title] ."</title>\n";

		$xml .= "<description>". preview_text($rss[post_content], 500, 1) ."</description>\n";
		$xml .= "<link>http://127.0.0.1/login/view.php?action=view&amp;post_id=". $rss[post_id] ."</link>\n";
		$xml .= "</item>\n";
		}
		
		//en of the RSS, also static
		$xml .= "</channel>\n";
		$xml .= "</rss>";
		
		fwrite($file, $xml);
		fclose($file);
		
		$red_link = $main_url . "rss.xml";
		redirect($red_link, 2);
		
		ob_flush();
	
?>