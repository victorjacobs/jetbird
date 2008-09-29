<?xml version="1.0"?>
<rss version="2.0">
	<channel>
		<title>{$config.title}</title>
		<link>{$config.link}</link>
		<description>{$config.description}</description>
		<lastBuildDate>{$rss.lastbuild}</lastBuildDate>
		<generator>Jetbird Revision 112</generator>
		<ttl>{$config.ttl}</ttl>		
		{foreach from=$rss.data item=item}	<item>
			<title>{$item.post_title}</title>
			<link>{$config.link}?view&amp;id={$item.post_id}</link>
			<description>{$item.description}</description>
			<author>{$item.user_name}</author>
			<comments>{$config.link}?view&amp;id={$item.post_id}#comments</comments>
			<pubDate>{$item.post_date}</pubDate>
		</item>
	{/foreach}</channel>
</rss>