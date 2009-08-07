{include file="head.tpl"}

	<div id="content">
		
		{if empty($posts)}
		<div class="post">
			<h2>Welcome to Jetbird v1.0</h2>
			<small>{$smarty.now|date_format:"%e %B %Y"}</small>
			
			<div class="entry">
				Seems that the owner of this site hasn't posted anything yet!
				Please come back later.{if $smarty.session.login}<br />
				<a href="./admin/?post&amp;new">New post</a>
			</div>{/if}
		</div>
		{else}
		{foreach from=$posts item=post}
		<div class="post">
			<h2><a href="./?view&amp;id={$post.post_id}">{$post.post_title}</a></h2>
			<small>{$post.post_date|date_format:"%e %B %Y"}</small>
			
			<div class="entry">
				{$post.post_content|truncate:500|bbcode|nl2br}
			</div>
			
			<p class="postmetadata">
				<img src="{$template_dir}/image/blog/speech_bubble.gif" alt="" /> {if $post.comment_count == 0}No comments{elseif $post.comment_count == 1}1 comment{else}{$post.comment_count} comments{/if}
				| <img src="{$template_dir}/image/blog/documents.gif" alt="" /> <i>Tagslist here</i>
				<!--| <img src="{$template_dir}/image/blog/permalink.gif" alt="" /> <a href="#" rel="bookmark" title="Permanent Link to test">Permalink</a>-->
				<br />
				<img src="{$template_dir}/image/blog/figure_ver1.gif" alt="" /> Posted by {$post.user_name|ucfirst}
			</p>
		</div>
		{/foreach}
		
		<hr />
		
		{if $pagination.total_pages != 1}
		<div class="navigation">
			{if $pagination.prev}<div class="alignleft"><a href="./?page={math equation="x + 1" x=$pagination.page}">&laquo; Previous Entries</a></div>{/if}
			{if $pagination.next}<div class="alignright"><a href="./?page={math equation="x - 1" x=$pagination.page}">Next Entries &raquo;</a></div>{/if}
		</div>
		{/if}
		{/if}
		
	</div>

{include file="foot.tpl"}