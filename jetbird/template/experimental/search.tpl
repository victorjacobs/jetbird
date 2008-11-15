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
			<h2>Jetbird - Search</h2>
			<small>Search results</small>
			
			{if isset($results)}
			{foreach from=$results item=result}
			<h3>{$result.post_title}</h3>
			<small class="subtitle">By {$result.user_name|ucfirst} on {$result.post_date|date_format:"%d/%m/%y"}</small>
			
			<p>{$result.post_content|truncate:500|nl2br}</p>
			<p><small>
				<a href="./?view&amp;id={$result.post_id}">Read more</a>{if $smarty.session.user_level == 1} | <a href="./?post&amp;edit&amp;id={$result.post_id}">Edit</a>{/if}

			</small></p>{/foreach}
			{else}
			<p>No search results</p>
			{/if}
		</div>
	</div>

{include file="foot.tpl"}