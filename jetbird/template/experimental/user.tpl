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

{include file="head.tpl"}

	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Blog</h2>
				<small>The everyday problems of two geeks.</small>
				{if !isset($smarty.session.login)}
				{if $login === FALSE}
				<p class="error"><b>Error:</b> password or username wrong, please try again.</p>
				{/if}
				<p>
					<form name="input" action="./?user&amp;action=login" method="post">
						<table>
							<tr>
								<td><b>Username</b></td>
								<td><input type="text" name="username" /></td>
							</tr>

							<tr>
								<td><b>Password</b></td>
								<td><input type="password" name="password"></td>
							</tr>

							<tr>
								<td><b>Remind me</b></td>
								<td><input type="checkbox" name="rememberlogin" /></td>
							</tr>

							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Login" /></td>
							</tr>
						</table>
					</form>
				</p>
				{elseif isset($smarty.session.login) && !isset($smarty.post.username)}
				<p><b>Error:</b> you are already logged in</p>
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}