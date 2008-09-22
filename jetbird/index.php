<?
//start the session first
session_start();
/*
/*	include section	       
*/

require ('C:\xampp\htdocs\blog2/include/common.php');
require ('C:\xampp\htdocs\blog2\include\smarty\Smarty.class.php');

/*
/*	smarty config && BBcode initialization section & DB connect      
*/

//smarty
$smarty = new Smarty();



$smarty->template_dir = 'C:\xampp\htdocs\blog2\template\default';
$smarty->compile_dir = 'C:\xampp\htdocs\blog2\include\smarty\templates_c';
$smarty->cache_dir = 'C:\xampp\htdocs\blog2\include\smarty\cache';
$smarty->config_dir = 'C:\xampp\htdocs\blog2\include\smarty\configs';
//$smarty->debugging = TRUE;
database_connect("localhost","tidus","tidus","login");

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
				ON post.puser_id=users.user_id
				ORDER BY post.post_id DESC LIMIT 5";	
				
	$result = query($query);
	
	// placing all the data in one array
	while($row = mysql_fetch_array($result)) {
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
	$smarty->display('index.tpl');

/*
/*	footer section	      
*/
?>
	