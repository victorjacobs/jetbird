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
	<title>Jetbird</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body>

	<div id="content" style="width: 345px; margin: auto; text-align: center;">
		
		<h2>Jetbird login</h2>
		{if $login === FALSE}
		<p class="error"><b>Error:</b> password or username wrong, please try again.</p>
		{/if}
		<p>
			<form name="input" action="./?login" method="post">
				<table style="text-align: right; margin-bottom: 10px;">
					<tr>
						<td>Username</td>
						<td><input type="text" name="username" /></td>
					</tr>
	
					<tr>
						<td>Password</td>
						<td><input type="password" name="password"></td>
					</tr>
	
					<tr>
						<td>Remember me</td>
						<td style="text-align: left;"><input type="checkbox" name="rememberlogin" /></td>
					</tr>
				</table>
	   		
	   		<input type="submit" name="submit" value="Login" />
			</form>
		</p>
		
	</div>
	
</body>

</html>