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
				
				<h3>{$post.post_title}</h3>
				<small class="subtitle">By {$post.user_name|ucfirst} on {$post.post_date|date_format:"%d/%m/%y"} in 
				{foreach from=$tags item=tag} 
				<a href="./?search&action=search_weight&text={$tag.tag}">{$tag.tag}</a>
				{/foreach}
				</small>
				
				<p>{$post.post_content|bbcode|nl2br}</p>
				
				{if $smarty.session.user_level == 1}<p>
					<small>
						<a href="./admin/?post&amp;edit&amp;id={$smarty.get.id}">Edit</a> | <a href="#" class="needs_confirmation" name="del_post_{$smarty.get.id}">Delete</a>
					</small>
				</p>{/if}
				
				<h3 id="comments">Comments{if $post.comment_status == "closed" and $smarty.session.user_level == 1} - Closed{/if}</h3>
				{if !$comments and $post.comment_status == "closed" and $smarty.session.user_level != 1}
				<p>Comments closed</p>
				{else}
				{if !empty($comments)}
				{foreach from=$comments item=comment}
				<div class="comment">
					<p>{$comment.comment_content|bbcode|nl2br}</p>
					<p><small>{if !empty($comment.comment_author_url)}<a href="{$comment.comment_author_url}">{/if}{$comment.comment_author}{if !empty($comment.comment_author_url)}</a>{/if} on {$comment.comment_date|date_format:"%d/%m/%y %H:%I"}</small></p>
				</div>
				{/foreach}
				{if $pagination.total_pages != 1}
				<small>
					<p>
						{if $pagination.prev}<a href="./?view&amp;id={$smarty.get.id}&amp;page={math equation="x + 1" x=$pagination.page}#comments">&laquo; Older comments</a>{/if}
						{if $pagination.next}{if $pagination.prev} | {/if}<a href="./?view&amp;id={$smarty.get.id}&amp;page={math equation="x - 1" x=$pagination.page}#comments">Newer comments &raquo;</a>{/if}
					</p>
				</small>
				{/if}
				{else}
				<p>No comments yet, be the first to write one!</p>
				{/if}
				<h3 id="add_comment">Add comment{if $smarty.session.user_level == 1 and $comment_status == "closed"} (closed){/if}</h3>
				{if $smarty.session.user_level == 1 or $post.comment_status == "open"}
				{if isset($comment_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
				<form action="./?post&amp;comment&amp;id={$smarty.get.id}" method="post">
					<div>
						<input type="text" name="author"{if isset($comment_data.author)} value="{$comment_data.author}"{/if} />
						<b><small>Name (required)</small></b>
					</div>
					
					<div>
						<input type="text" name="email"{if isset($comment_data.email)} value="{$comment_data.email}"{/if} />
						<b><small>Mail (required, won't be shown in public)</small></b>
					</div>
					
					<div>
						<input type="text" name="website"{if isset($comment_data.website)} value="{$comment_data.website}"{/if} />
						<b><small>Website</small></b>
					</div>
					
					<div>
						<textarea rows="10" cols="40" name="comment">{if isset($comment_data.comment)}{$comment_data.comment}{/if}</textarea>
					</div>
					
					<div>
						<input type="submit" name="submit" value="Send" />
					</div>
				</form>
				{else}
				<p>Comments closed</p>
				{/if}
				{/if}
			</div>
		</div>
		
{include file="foot.tpl"}