{include file="head.tpl"}

	<div id="content" class="widecolumn">
		
		<div class="post">
			<h2>{$post.post_title}</a></h2>
			
			<div class="entry">
				{$post.post_content|bbcode|nl2br}
			</div>
		</div>
		
		<p class="postmetadata alt">
			<small>
				This entry was posted

				on {$post.post_date|date_format:"%e %B %Y at %R"} by {$post.user_name|ucfirst}{if !empty($post.tags)}
				and is filed under {$post.tags|replace:' ':', '}{/if}.
				You can follow any responses to this entry through the <a href="./feed/">RSS</a> feed.
				{if $post.comment_status == "open"}You can <a href="./?view&amp;id={$smarty.get.id}#comments">leave a response
				{else}Comments are closed{/if}
			</small>
		</p>
		
		<h3 id="comments">20 Responses to &#8220;MySQL table and column&nbsp;names&#8221;</h3>
		
		<ol class="commentlist">
			<li class="comment even thread-even depth-1" id="comment-9">
				<cite><a href='http://p42.us' rel='external nofollow' class='url'>thornmaker</a></cite> Says:<br />
				<p>good writeup!</p>

			</li>
			
			<li class="comment byuser comment-author-websec bypostauthor odd alt thread-odd thread-alt depth-1" id="comment-10">
				<cite>Reiners</cite> Says:						<br />
				<p>Thanks, glad you like it <img src='http://s.wordpress.com/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley' /> </p>
		</li>

		</ol>
		
		{if $pagination.total_pages != 1}
		<div class="navigation">
			{if $pagination.prev}<div class="alignleft"><a href="./?page={math equation="x + 1" x=$pagination.page}">&laquo; Previous Entries</a></div>{/if}
			{if $pagination.next}<div class="alignright"><a href="./?page={math equation="x - 1" x=$pagination.page}">Next Entries &raquo;</a></div>{/if}
		</div>
		{/if}
		
	</div>

{include file="foot.tpl"}