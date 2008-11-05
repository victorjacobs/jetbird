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
			<small>Manage Posts</small>
			
			{if isset($smarty.get.new)}
			{if isset($post_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
			<form name="input" action="./?post&amp;add" method="post">
				<p><table>
					<tr>
						<td><b>Title</b></td>
						<td><input type="text" name="post_title"{if isset($post_data.post_title)} value="{$post_data.post_title}"{/if} /></td>
					</tr>

					<tr>
						<td valign="top"><b>Text</b></td>
						<td><textarea rows="20" cols="55" name="post_content">{if isset($post_data.post_content)}{$post_data.post_content}{/if}</textarea></td>
					</tr>

					<tr>
						<td><b>Comments</b></td>
						<td>
							<select name="comment_status">
								<option value="open" selected>Open</option>
								<option value="closed">Closed</option>
							</select>
						</td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="submit" value="Post" /></td>
					</tr>
				</table></p>
			</form>
			{/if}
		</div>
	</div>

{include file="foot.tpl"}