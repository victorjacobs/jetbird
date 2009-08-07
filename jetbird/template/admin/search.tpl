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

		<div id="content">
			
			<h2>Search</h2>
			
			<h3>Statistics</h3>
			<p>Total words: <b>{$stats.total_words}</b></p>
			
			{if $ask === true}
			<p>
				<a href="#" name="reindex" class="needs_confirmation">Reindex?</a>
			</p>
			{/if}
			
			
			{if $ask === false}
			<p>Reindexed all the posts successful.</p>
			{/if}
			
		</div>
		
{include file="foot.tpl"}