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
			{$common_dir}
			<h2>Command line</h2>
			<h3>Execute some {if isset($smarty.get.php)}PHP{/if}{if isset($smarty.get.sql)}SQL{/if} right on the server</h3>
			
			<form action="./?cmd&amp;{if isset($smarty.get.php)}php{/if}{if isset($smarty.get.sql)}sql{/if}" method="post">
				<p>
					<textarea name="command" cols="70" rows="20"></textarea>
				</p>
				
				<p>
					<input type="submit" name="submit" value="Go" />
				</p>
			</form>
				
			
		</div>
		
{include file="foot.tpl"}