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
			
			<h2>Manage posts</h2>
			
			{if isset($smarty.get.edit) && $smarty.session.user_level == 1}
			{if isset($edit_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
			<h3>Edit</h3>
			
			<form name="input" action="./?post&amp;edit&amp;id={$smarty.get.id}" method="post">
				<p>
					<table>
						<tr>
							<td><b>Title</b></td>
							<td><input type="text" name="post_title" size="57" value="{$post_title}" /></td>
						</tr>
						
						<tr>
							<td valign="top"><b>Text</b></td>
							<td><textarea rows="20" cols="55" name="post_content">{$post_content}</textarea></td>
						</tr>
						
						<tr>
							<td><b>Comments</b></td>
							<td>
								<select name="comment_status">
									<option value="open"{if $comment_status == "open"} selected{/if}>Open</option>
									<option value="closed"{if $comment_status == "closed"} selected{/if}>Closed</option>
								</select>
							</td>
						</tr>
												
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit" value="Edit" /></td>
						</tr>
					</table>
				</p>
			</form>
			{elseif isset($smarty.get.new)}
			{if isset($post_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
			<h3>New</h3>
			
			<form accept-charset="utf-8" name="input" action="./?post&amp;new" method="post">
				<p>
					<table>
						<tr>
							<td><b>Title</b></td>
							<td><input type="text" name="post_title" size="57"{if isset($post_data.post_title)} value="{$post_data.post_title}"{/if} /></td>
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
					</table>
				</p>
			</form>
			{elseif isset($smarty.get.delete)}
			<p><b>Error:</b> don't use this in this template</p>
			{else}
			<h3>Overview</h3>
			
			<p>
				<table width="100%">
					<tr>
						<td width="35%"><b>Title</b></td>
						<td><b>Author</b></td>
						<td><b>Date</b></td>
						<td><b>Comments</b></td>
						<td width="1">&nbsp;</td>
						<td width="1">&nbsp;</td>
					</tr>
					
					{foreach from=$posts item=post}
					<tr>						
						<td><a href="../?view&amp;id={$post.post_id}">{$post.post_title}</a></td>
						<td>{$post.user_name|ucfirst}</td>
						<td>{$post.post_date|date_format:"%d/%m/%y %H:%I"}</td>
						<td>{$post.comment_status|ucfirst}</td>
						<td><a href="./?post&amp;edit&amp;id={$post.post_id}">Edit</a></td>
						<td><a class="needs_confirmation" href="#" name="del_post_{$post.post_id}">Delete</a></td>
					</tr>
					{/foreach}
				</table>
			</p>
			
			<p>
				<a href="./?post&amp;new">New post</a>
			</p>
			{/if}
			
		</div>
		
{include file="foot.tpl"}