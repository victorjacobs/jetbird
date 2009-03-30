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

		<div id="content">
			<h2>Register</h2>
			
			{if !$success}
			{if isset($register_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
			<p>
				<form action="./?register&amp;key={$smarty.get.key}" method="post">
					<table>
						<tr>
							<td><b>Username</b></td>
							<td><input type="text" name="username"{if isset($register_data.username)} value="{$register_data.username}"{/if} /></td>
						</tr>

						<tr>
							<td><b>Password</b></td>
							<td><input type="password" name="pass" /></td>
						</tr>

						<tr>
							<td><b>Confirm</b></td>
							<td><input type="password" name="pass_confirm" /></td>
						</tr>
						
						<tr>
							<td><b>Email</b></td>
							<td><input type="text" name="mail"{if isset($register_data.mail)} value="{$register_data.mail}"{/if} /></td>
						</tr>
						
						<tr height="50">
							<td>&nbsp;</td>
							<td><img src="./?captcha" alt="" /></td>
						</tr>
						
						<tr>
							<td><b>Security image:</b></td>
							<td><input type="text" name="captcha" /></td>
						</tr>

						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit" value="Register" /></td>
						</tr>
					</table>
				</form>
			</p>
			{else}
			<p>
				You successfully registered, you can now login with your username and password
			</p>
			{/if}
			
		</div>
		
{include file="foot.tpl"}