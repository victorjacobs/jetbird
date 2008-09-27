{*
	This file is part of Jetbird.

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
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Jetbird Preview</title>
	<link type="text/css" rel="stylesheet" media="screen" href="{$template_dir}/css/style.css" />
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
					<form name="input" action="./?user&amp;action=login" method="post">
					Username: 
					<input type="text" name="username"> <br />
					Password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>	
					{elseif isset($smarty.session.login) && !isset($smarty.post.username)}
					you are already logged in <br />
					{/if}
					
					{if $login === TRUE}
					Welcome back {$smarty.session.username} <br />
					Redirecting to control panel...
					{/if}
					
					{if $login === FALSE}
					Password or username wrong, please try again.
					{/if}
				
				{elseif $smarty.get.action == logout}
				You successfully logged out
				
				{elseif $smarty.get.action == register}
				
					{if $register_key === TRUE}
					<form name="input" action="./?user&amp;action=register&amp;key={$smarty.get.key}" method="post">
					Username: 
					<input type="text" name="username"> <br />
					password:
					<input type="password" name="password"> <br />
					<input type="submit" value="submit"/>
					</form>
					{/if}
					
					{if $register === TRUE}
					You are successully registered, please login
					{/if}
					
					{if $register_exist === TRUE}
					Username already exists
					{/if}
					
					{if $register_key === FALSE}
					Wrong registration key
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
	