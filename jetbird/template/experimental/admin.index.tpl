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
				<h2>Jetbird - Admin</h2>
				<small>Statistics</small>
				
				<h3>Recent comments</h3>
				
				<p>
					<table width="100%">
						<tr>
							<td width="100"><b>Date</b></td>
							<td><b>Post</b></td>
							<td><b>Author</b></td>
							<td width="40"><b>IP</b></td>
						</tr>
						
					{foreach from=$comments item=comment}	<tr>
							<td>{$comment.comment_date|date_format:"%d/%m/%y %H:%I"}</td>
							<td><a href="../?view&amp;id={$comment.comment_parent_post_id}#comments">{$comment.post_title}</a></td>
							<td>{if !empty($comment.comment_author_url)}<a href="{$comment.comment_author_url}" target="_blank">{/if}{$comment.comment_author}{if isset($comment.comment_author_url)}</a>{/if}</td>
							<td>{$comment.comment_author_ip}</td>
						</tr>
					{/foreach}</table>
				</p>
			</div>
		</div>
		
{include file="foot.tpl"}