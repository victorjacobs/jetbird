{*This file is part of jetbird.

    jetbird is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Jetbird Preview</title>
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
					<form name="input" action="./?user&action=login" method="post">
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
					<form name="input" action="./?user&action=register" method="post">
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
		Number of queries: {$queries}
		</div>
		
	</div> 
	
</body>
</html>
	