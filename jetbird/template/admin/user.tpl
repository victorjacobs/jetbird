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
			
			<h2>Manage users</h2>
			
			{if isset($smarty.get.invite)}
			<h3>Invite</h3>
			<p>
				<form action="./?user&amp;invite" method="post">
					<p>
						Email address: <input type="text" name="email" />
					</p>
					<input type="submit" name="submit" value="Send" />
				</form>
			</p>
			{elseif isset($smarty.get.edit)}
			<h3>Edit</h3>
			{if isset($edit_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
			<p>
				<form action="./?user&amp;edit&amp;id={$smarty.get.id}" method="post">
					<table>
						<tr>
							<td><b>Username</b></td>
							<td><input type="text" name="user_name" value="{$user.0.user_name}" /></td>
						</tr>
						
						<tr>
							<td><b>User level</b></td>
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
				<h3>Generate keys</h3>
				{if !isset($keys)}
				{if isset($generate_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
				<form action="./?user&amp;generate" method="post">
					<p>
						Number:
						<select name="key_count">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</p>
					
					<input type="submit" name="submit" value="Generate" />
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
			{elseif isset($smarty.get.delete)}
			<p><b>Error:</b> Don't use this in this template</p>
			{else}
			<h3>Overview</h3>
			<p>
				<table>
					<tr>
						<td width="150"><b>Name</b></td>
						<td width="170"><b>Mail</b></td>
						<td width="110"><b>Last login</b></td>
						<td width="30">&nbsp;</td>
						<td width="1">&nbsp;</td>
					</tr>
					{foreach from=$users item=user}
					<tr>
						<td{if $user.user_level == -2} style="background-color: #89322e; color: white;"{/if}>{$user.user_name}</td>
						<td>{$user.user_mail}</td>
						<td>{if !$user.user_last_login}<i>Never</i>{else}{$user.user_last_login|date_format:"%d/%m/%y %H:%I"}{/if}</td>
						<td><a href="./?user&amp;edit&amp;id={$user.user_id}">Edit</a></td>
						<td><a href="#" class="needs_confirmation" name="del_user_{$user.user_id}">{if $user.user_level == -2}Restore{else}Delete{/if}</a></td>
					</tr>
					{/foreach}
				</table>
			</p>
			<p><a href="./?user&amp;invite">Invite user</a> | {if !isset($smarty.get.deleted)}<a href="./?user&amp;deleted">Also display deleted users</a>{else}<a href="./?user">Only display existing users</a>{/if}</p>
			
			<h3>Inactivated keys</h3>
			<p>
				<table>
					<tr>
						<td width="150"><b>Key</b></td>
						<td width="170"><b>Sent to</b></td>
						<td width="98"><b>Created on</b></td>
					</tr>
					{if !empty($keys)}
					{foreach from=$keys item=key}
					<tr>
						<td>{$key.user_reg_key}</td>
						<td>{if empty($key.user_mail)}<i>No one</i>{else}{$key.user_mail}{/if}</td>
						<td>{$key.user_last_login|date_format:"%d/%m/%y %H:%I"}</td>
					</tr>
					{/foreach}
					{/if}
				</table>
			</p>
			<p>
				<a href="./?user&amp;generate">Generate keys</a>
			</p>
			{/if}
			
		</div>
		
{include file="foot.tpl"}