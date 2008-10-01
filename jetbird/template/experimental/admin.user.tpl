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
				
				{if $smarty.get.action == "new_user"}
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
				{else}
				<p>
					<table>
						<tr>
							<td><b>Id</b></td>
							<td width="70"><b>Name</b></td>
							<td><b>Level</b></td>
							<td><b>Mail</b></td>
							<td><b>Last login</b></td>
							<td><b>Reg key</b></td>
							<td>&nbsp;</td>
						</tr>
						{foreach from=$users item=user}
						<tr>
							<td>{$user.user_id}</td>
							<td>{$user.user_name}</td>
							<td>{$user.user_level}</td>
							<td>{$user.user_mail}</td>
							<td><i>Placeholder</i></td>
							<td>{$user.user_reg_key}</td>
							<td><a href="#">Edit</a></td>
						</tr>
						{/foreach}
					</table>
				</p>
				<p><a href="./?user&amp;action=new_user">Add user</a></p>
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}