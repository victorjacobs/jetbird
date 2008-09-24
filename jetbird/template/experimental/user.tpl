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
	<title>Jetbird Preview &raquo; One</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<!-- Squish IE quirks -->
	<!--[if lt IE 7]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
	<![endif]-->
	<link type="text/css" rel="stylesheet" media="screen" href="template/experimental/css/style.css" />
</head>

<body>
	
	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Blog</h2>
				<small>The everyday problems of two geeks.</small>
				{if $smarty.get.action == login}
				{if !isset($smarty.session.login)}
				<form name="input" action="./?user&amp;action=login" method="post">
					<p><table>
						<tr>
							<td><b>Username</b></td>
							<td><input type="text" name="username" /></td>
						</tr>
						
						<tr>
							<td><b>Password</b></td>
							<td><input type="password"></td>
						</tr>
						
						<tr>
							<td><b>Remind me</b></td>
							<td><input type="checkbox" name="rememberlogin" disabled /></td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" value="Login" /></td>
						</tr>
					</table></p>
				</form>
				{elseif isset($smarty.session.login) && !isset($smarty.post.username)}
				<p><b>Error:</b> you are already logged in</p>
				{/if}
				
				{if $login === TRUE}
				<p>Redirecting to home page</p>
				{/if}
				
				{if $login === FALSE}
				<p>Password or username wrong, please try again.</p>
				{/if}
				
				{elseif $smarty.get.action == logout}
				<p>You successfully logged out</p>
				
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}