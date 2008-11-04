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
				<h2>Jetbird - Admin</h2>
				<small>Manage users</small>
				
				{if isset($smarty.get.invite)}
				<h3>Add user</h3>
				<p>
					<form action="./?user&amp;add_user" method="post">
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
					</form>
				</p>
				{elseif isset($smarty.get.edit)}
				<h3>Edit User</h3>
				<p>
					<form action="./?user&amp;edit" method="post">
						<table>
							<tr>
								<td><b>Username</b></td>
								<td><input type="text" /></td>
							</tr>
							
							<tr>
								<td><b>Userlevel</b></td>
								<td>
									<select>
										<option>Owner</option>
										<option>Moderator</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td><b>New password</b></td>
								<td><input type="password" /></td>
							</tr>
							
							<tr>
								<td><b>Retype password</b></td>
								<td><input type="password" /></td>
							</tr>
							
							<tr>
								<td><b>Email</b></td>
								<td><input type="text" /></td>
							</tr>
						</table>
						<input type="submit" value="Update" name="submit" />
					</form>
				</p>
				{else}
				<h3>Overview</h3>
				<p>
					<table width="100%">
						<tr>
							<td><b>ID</b></td>
							<td width="70"><b>Name</b></td>
							<td><b>Level</b></td>
							<td><b>Mail</b></td>
							<td><b>Last login</b></td>
							<td>&nbsp;</td>
						</tr>
						{foreach from=$users item=user}
						<tr>
							<td>{$user.user_id}</td>
							<td>{$user.user_name}</td>
							<td>{$user.user_level}</td>
							<td>{$user.user_mail}</td>
							<td>{if !$user.user_last_login}<i>Never</i>{else}{$user.user_last_login|date_format:"%D %H:%I"}{/if}</td>
							<td><a href="./?user&amp;edit&amp;id={$user.user_id}">Edit</a></td>
						</tr>
						{/foreach}
					</table>
				</p>
				<p><a href="./?user&amp;action=new_user">Add user</a></p>
				
				<h3>Inactivated register keys</h3>
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}