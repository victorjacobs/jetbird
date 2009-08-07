{include file="head.tpl"}

	<div id="content">
		
		{if !isset($results)}
		<div class="post">
			<h2>Search</h2>
			
			<div class="entry">
				No results
			</div>
		</div>
		{else}
		{foreach from=$results item=post}
		<div class="post">
			<h2><a href="./?view&amp;id={$post.post_id}">{$post.post_title}</a></h2>
			<small>{$post.post_date|date_format:"%e %B %Y"}</small>
			
			<div class="entry">
				{$post.post_content|truncate:500|bbcode|nl2br}
			</div>
			
			<p class="postmetadata">
				<img src="{$template_dir}/image/blog/speech_bubble.gif" alt="" /> No comments
				| <img src="{$template_dir}/image/blog/documents.gif" alt="" /> <i>Tagslist here</i>
				<!--| <img src="{$template_dir}/image/blog/permalink.gif" alt="" /> <a href="#" rel="bookmark" title="Permanent Link to test">Permalink</a>-->
				<br />
				<img src="{$template_dir}/image/blog/figure_ver1.gif" alt="" /> Posted by {$post.user_name|ucfirst}
			</p>
		</div>
		{/foreach}
		
		<hr />
		{/if}
		
	</div>

{include file="foot.tpl"}