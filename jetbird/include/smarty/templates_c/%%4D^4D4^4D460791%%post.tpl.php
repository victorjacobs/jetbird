<?php /* Smarty version 2.6.20, created on 2008-09-15 19:34:05
         compiled from post.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> blog pre-alpha v0.03 </title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div id="wrap_main">
	
		<div id="wrap_header">
		</div>
		
		<div id="wrap_content">
				<div id="content">
				
				<?php if ($_GET['action'] == main_make_post && $_SESSION['auth_id'] == 1): ?>
				<form name="input" action="post.php?action=main_make_post" method="post">
				title
				<textarea rows="2.5" cols="50" name="main_title" ></textarea>  <br />
				text
				<textarea rows="10" cols="50" name="main_text" ></textarea> <br />
				<input type="submit" value="Post"/>
				</form>
	
				<?php elseif ($_GET['action'] == main_edit_post && $_SESSION['auth_id'] == 1): ?>
				<form name="input" action="post.php?action=main_edit_post&amp;post_id=<?php echo $_GET['post_id']; ?>
" method="post">
				title
				<textarea rows="2.5" cols="50" name="main_title" ></textarea>  <br />
				text
				<textarea rows="10" cols="50" name="main_text" ></textarea> <br />
				<input type="submit" value="Post"/>
				</form>
				<?php else: ?>
				You do not have the required authorisation to perform this action.
				<?php endif; ?>
				
				</div>
		</div>
		
		<div id="wrap_footer">
		</div>
		
	</div> 
	
</body>
</html>
	