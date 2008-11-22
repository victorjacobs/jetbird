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
				{if isset($edit_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
				<p>
					<form action="./?user&amp;edit&amp;id={$smarty.get.id}" method="post">
						<table>
							<tr>
								<td><b>Username</b></td>
								<td><input type="text" name="user_name" value="{$user.0.user_name}" /></td>
							</tr>
							
							<tr>
								<td><b>Userlevel</b></td>
								<td>
									<select disabled>
										<option>Owner</option>
										<option>Moderator</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td><b>Email</b></td>
								<td><input type="text" name="user_mail" value="{$user.0.user_mail}" /></td>
							</tr>
							
							<tr>
								<td><b>New password</b></td>
								<td><input type="password" name="pass" /></td>
							</tr>
							
							<tr>
								<td><b>Retype password</b></td>
								<td><input type="password" name="pass_confirm" /></td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Update" name="submit" /></td>
							</tr>
						</table>
					</form>
				</p>
				{elseif isset($smarty.get.generate)}
				<p>
					<h3>Generate registration keys</h3>
					{if !isset($keys)}
					{if isset($generate_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
					<form action="./?user&amp;generate" method="post">
						<p>
							<table>
								<tr>
									<td><b>Number</b></td>
									<td><input type="text" name="key_count" value="1" /></td>
								</tr>

								<tr>
									<td>&nbsp;</td>
									<td><input type="submit" name="submit" value="Create" /></td>
								</tr>
							</table>
						</p>
					</form>
					{else}
					<p>Following keys were created:</p>
					<ul>
					{foreach from=$keys item=key}
						<li>{$key}</li>
					{/foreach}
					</ul>
					{/if}
				</p>
						
				{else}
				<h3>Overview</h3>
				<p>
					<table width="100%">
						<tr>
							<td><b>ID</b></td>
							<td width="100"><b>Name</b></td>
							<td><b>Mail</b></td>
							<td><b>Last login</b></td>
							<td width="1">&nbsp;</td>
							<td width="1">&nbsp;</td>
						</tr>
						{foreach from=$users item=user}
						<tr>
							<td>{$user.user_id}</td>
							<td>{$user.user_name}</td>
							<td>{$user.user_mail}</td>
							<td>{if !$user.user_last_login}<i>Never</i>{else}{$user.user_last_login|date_format:"%d/%m/%y %H:%I"}{/if}</td>
							<td><a href="./?user&amp;edit&amp;id={$user.user_id}">Edit</a></td>
							<td><a href="#" class="needs_confirmation" name="del_user_{$user.user_id}">Delete</a></td>
						</tr>
						{/foreach}
					</table>
				</p>
				<p><a href="./?user&amp;action=new_user">Add user</a></p>
				
				<h3>Inactivated register keys</h3>
				<p>
					<table width="100%">
						<tr>
							<td width="150"><b>Key</b></td>
							<td><b>Sent to</b></td>
							<td width="96"><b>Created on</b></td>
						</tr>
						{foreach from=$keys item=key}
						<tr>
							<td>{$key.user_reg_key}</td>
							<td>{if empty($key.user_mail)}<i>No one</i>{else}{$key.user_mail}{/if}</td>
							<td>{$key.user_last_login|date_format:"%d/%m/%y %H:%I"}</td>
						</tr>
						{/foreach}
					</table>
				</p>
				<p>
					<a href="./?user&amp;generate">Generate keys</a>
				</p>
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}