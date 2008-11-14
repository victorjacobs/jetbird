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
				
				{foreach from=$posts item=post}
				<h3>{$post.post_title}</h3>
				<small class="subtitle">By {$post.user_name|ucfirst} on {$post.post_date|date_format:"%d/%m/%y"}</small>
				
				<p>{$post.post_content|truncate:500|bbcode|nl2br}</p>
				<p><small>
					<a href="./?view&amp;id={$post.post_id}">Read more</a>{if $smarty.session.user_level == 1} | <a href="./?post&amp;edit&amp;id={$post.post_id}">Edit</a>{/if}

				</small></p>
				{/foreach}
			</div>
		</div>
		
{include file="foot.tpl"}