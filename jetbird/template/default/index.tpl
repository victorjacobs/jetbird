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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Jetbird Preview</title>
	<link type="text/css" rel="stylesheet" media="screen" href="{$template_dir}/css/style.css" />
</head>

<body>

	
		<div id="wrap_main">
		
			{include file="head.tpl"}
			
			<div id="wrap_content">
			{foreach from=$posts item=post}
				<div class="post">
					<div class="title">
					{$post.post_title}
					</div>
					
					<div class="author">
					By {$post.user_name|ucfirst} on {$post.post_date|date_format:"%d/%m/%y"}
					</div>
					
					<p>{$post.post_content|truncate:500|bbcode|nl2br}</p>
					<br />
					
					<div class="links">
					<a href="./?view&amp;id={$post.post_id}">Read more</a>
					{if $smarty.session.user_level == 1} | <a href="./?post&amp;edit&amp;id={$post.post_id}">Edit</a>{/if}

					</div>
				</div>
				<br />
				{/foreach}
				
			</div>	
		{include file="menu.tpl"}
		{include file="foot.tpl"}	
	</div>
	
</body>
</html>
	