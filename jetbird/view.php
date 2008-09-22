<?
//start the session first
session_start();
/*
/*	include section	       
*/

require ('C:\xampp\htdocs\blog2/include/common.php');
require ('C:\xampp\htdocs\blog2\include\smarty\Smarty.class.php');

/*
/*	smarty config section & DB connect      
*/

$smarty = new Smarty();

$smarty->template_dir = 'C:\xampp\htdocs\blog2\template\default';
$smarty->compile_dir = 'C:\xampp\htdocs\blog2\include\smarty\templates_c';
$smarty->cache_dir = 'C:\xampp\htdocs\blog2\include\smarty\cache';
$smarty->config_dir = 'C:\xampp\htdocs\blog2\include\smarty\configs';
//$smarty->debugging = TRUE;
database_connect("localhost","tidus","tidus","login");

switch ($_GET['action']) {

/*
/*	view section     
*/	
	case view_post:
	
	/*
	/*	the main post section, here the main post will be done.    
	*/	
	
		if (!isset($_GET['post_id'])) {
			$smarty->assign('view', FALSE);
		}
		
		$query = "SELECT post, title, date
					FROM post
					WHERE post_id = '$_GET[post_id]'";
	
		
		
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result) == 1)
		{
			$row = mysql_fetch_array($result);
			$smarty->assign('view_post', nl2br($row['post']));
			$smarty->assign('view_date', date("D M j G:i  Y", $row['date']));
			$smarty->assign('view_title', $row['title']);
		}
		else
		{
		$smarty->assign('view', FALSE);
		}
		
	/*
	/*	the comments sections, here the comments will be done   
	*/		
	
		$query = "	SELECT comment.comment_parent_id, comment.comment, comment.comment_date,
							users.username, users.user_id, comment.comment_id, comment.pcomment_id
							FROM comment, users
							WHERE comment_parent_id = ". $_GET['post_id'] ."
							AND comment.pcomment_id = users.user_id";
	
		$result = mysql_query($query) or die($query);
	
		while ($row = mysql_fetch_array($result)) {
			$view_content['comment'][] = nl2br($row['comment']);
			$view_content['date'][] = date("D M j G:i  Y", $row['comment_date']);
			$view_content['username'][] = $row['username'];
			
			}
			
		$smarty->assign('comment', $view_content['comment']);
		$smarty->assign('date', $view_content['date']);
		$smarty->assign('username', $view_content['username']);		
	break;
		
	default:
		$smarty->assign('view', FALSE);
	}
		
$smarty->display('view.tpl');
?>