<?
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


//Database


	switch($_GET['action']) {
/*
/*	main post section    
*/		
		case main_make_post:
		
		if(isset($_POST['main_title'])) {
			$date = time();
			$parser = new HTML_BBCodeParser();
			$text = $parser->qParse(htmlspecialchars($_POST['main_text']));
			$query="	INSERT INTO post (post, date, puser_id, title) 
						VALUES ('$text', $date, '$_SESSION[user_id]', '$_POST[main_title]')";
			mysql_query($query) or die(mysql_error());
			redirect('./?main', 2);
		}	
		
		break;
		
		case main_edit_post:
			
		break;
		case make_comment:
		
			if (isset($_POST['comments_text'])) {
			$date = time();			
			$parser = new HTML_BBCodeParser();
			$text = $parser->qParse(htmlspecialchars($_POST['comments_text']));
			$query="	INSERT INTO comment (comment_parent_id, comment, pcomment_id, comment_date) 
						VALUES ('$_GET[post_id]', '$text', '$_SESSION[user_id]', $date)";
			mysql_query($query) or die(mysql_error());
			redirect("./?view&action=view_post&post_id=" . $_GET['post_id'] ."", 0);
			}
			
		break;
	}
$smarty->assign('queries', $dbconnection->queries);
$smarty->display('post.tpl');
ob_flush();
?>