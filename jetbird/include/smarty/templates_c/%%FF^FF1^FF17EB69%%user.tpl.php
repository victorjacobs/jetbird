<?php /* Smarty version 2.6.20, created on 2008-09-15 17:38:35
         compiled from user.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> blog pre-alpha v0.03 </title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />
	<script src="include/common.js"></script>
</head>

<body>
	<div id="wrap_main">
	
		<div id="wrap_header">
		</div>
		
		<div id="wrap_content">
				<div id="content">
				
				<?php if ($_GET['action'] == login): ?>
					<?php if (! isset ( $_SESSION['login'] )): ?>
					<form name="input" action="user.php?action=login" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>	
					<?php elseif (isset ( $_SESSION['login'] ) && ! isset ( $_POST['username'] )): ?>
					you are already logged in <br />
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['login'] === TRUE): ?>
					Welcome back <?php echo $_SESSION['username']; ?>
 <br />
					redirecting to home page...
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['login'] === FALSE): ?>
					password or username wrong, please try again.
					<?php endif; ?>
				
				<?php elseif ($_GET['action'] == logout): ?>
				you sucessfully logged out
				
				<?php elseif ($_GET['action'] == register): ?>
				
					<?php if (! isset ( $_SESSION['login'] )): ?>
					<form name="input" action="user.php?action=register" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>
					<?php elseif (isset ( $_SESSION['login'] ) && ! isset ( $_POST['username'] )): ?>
					you are already registered <br />
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['register'] === TRUE): ?>
					you are sucessully register, please login
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['register'] === FALSE): ?>
					username already exists
					<?php endif; ?>
					
				<?php else: ?>
				invalid URL please return to the home page.
				
				<?php endif; ?>
				</div>
		</div>
		
		<div id="wrap_footer">
		</div>
		
	</div> 
	
</body>
</html>
	