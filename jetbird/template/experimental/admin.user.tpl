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
	<script src="{$template_dir}/js/fix.js" type="text/javascript"></script>
	<!-- Squish IE quirks -->
	<!--[if lt IE 7]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
	<![endif]-->
	<link type="text/css" rel="stylesheet" media="screen" href="{$template_dir}/css/style.css" />
</head>

<body onLoad="bodyLoad();">
	
	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Admin</h2>
				<small>Invite a new user</small>
				
				<p><form action="./?user&amp;add_user" method="post">
					<table>
						<tr>
							<td>Email address</td>
							<td><input type="text" name="email" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit" value="Send" /></td>
						</tr>
					</table>
				</form></p>
			</div>
		</div>
		
{include file="foot.tpl"}