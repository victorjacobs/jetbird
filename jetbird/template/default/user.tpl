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
				
				{if $smarty.get.action == login}
					{if !isset($smarty.session.login)}
					<form name="input" action="user.php?action=login" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>	
					{elseif isset($smarty.session.login) && !isset($smarty.post.username)}
					you are already logged in <br />
					{/if}
					
					{if $login === TRUE}
					Welcome back {$smarty.session.username} <br />
					redirecting to home page...
					{/if}
					
					{if $login === FALSE}
					password or username wrong, please try again.
					{/if}
				
				{elseif $smarty.get.action == logout}
				you sucessfully logged out
				
				{elseif $smarty.get.action == register}
				
					{if !isset($smarty.session.login)}
					<form name="input" action="user.php?action=register" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>
					{elseif isset($smarty.session.login) && !isset($smarty.post.username)}
					you are already registered <br />
					{/if}
					
					{if $register === TRUE}
					you are sucessully register, please login
					{/if}
					
					{if $register === FALSE}
					username already exists
					{/if}
					
				{else}
				invalid URL please return to the home page.
				
				{/if}
				</div>
		</div>
		
		<div id="wrap_footer">
		</div>
		
	</div> 
	
</body>
</html>
	