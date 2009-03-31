<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
	<channel>
		<title>{$title}</title>
		<link>{$link}</link>
		<description>{$description}</description>
		<lastBuildDate>{$last_build_date}</lastBuildDate>
		<pubDate>{$pub_date}</pubDate>
		<generator>Jetbird 1.0</generator>
		<ttl>{$ttl}</ttl>		
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