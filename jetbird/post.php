<?
//start the session first & ob_start
ob_start();
session_start();

/*
/*	include section	       
*/

require ('C:\xampp\htdocs\blog2/include/common.php');
require ('C:\xampp\htdocs\blog2\include\smarty\Smarty.class.php');
require_once ('PEAR.php');
require_once ('HTML/BBCodeParser.php');

/*
/*	smarty config section & DB connect, BBcode setup   
*/

//smarty
$smarty = new Smarty();
$smarty->template_dir = 'C:\xampp\htdocs\blog2\template\default';
$smarty->compile_dir = 'C:\xampp\htdocs\blog2\include\smarty\templates_c';
$smarty->cache_dir = 'C:\xampp\htdocs\blog2\include\smarty\cache';
$smarty->config_dir = 'C:\xampp\htdocs\blog2\include\smarty\configs';
//$smarty->debugging = TRUE;

//bbcode
$config = parse_ini_file('conf/BBCodeParser.ini', true);
$options = &PEAR::getStaticProperty('HTML_BBCodeParser', '_options');
$options = $config['HTML_BBCodeParser'];
unset($options);

//Database
database_connect("localhost","tidus","tidus","login");

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
			redirect('http://127.0.0.1/blog2/index.php', 2);
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
			redirect("http://127.0.0.1/blog2/view.php?action=view_post&post_id=" . $_GET['post_id'] ."", 0);
			}
			
		break;
	}
$smarty->display('post.tpl');
ob_flush();
?>