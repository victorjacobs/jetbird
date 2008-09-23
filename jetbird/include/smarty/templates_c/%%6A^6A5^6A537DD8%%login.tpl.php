<?php /* Smarty version 2.6.20, created on 2008-09-07 18:43:55
         compiled from login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> blog pre-alpha v0.02 </title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div class="wrap_main">
	
		<div class="wrap_header">
		</div>
		
		<div class="wrap_content">
				<div class="content">
				
				<?php if ($_GET['action'] == login): ?>
				
					<?php if (! isset ( $_SESSION['login'] )): ?>
					<form name="input" action="login.php?action=login" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit">
					</form>	
					<?php endif; ?>
			
					
					<?php if ($this->_tpl_vars['login'] === TRUE): ?>
					you succesfully logged in
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['login'] === FAILED): ?>
					password or username wrong, please try again.
					<?php endif; ?>
					
					<?php if (isset ( $_SESSION['login'] )): ?>
					you are already logged in
					<?php endif; ?>
				
				
				<?php elseif ($_GET['action'] == logout): ?>
				you sucessfully logged out
				<?php else: ?>
				return to the home page please
				<?php endif; ?>
				</div>
		</div>
		
		<div class="wrap_footer">
		</div>
		
	</div> 
	
</body>
</html>
	