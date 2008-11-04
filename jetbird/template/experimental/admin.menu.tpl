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
<div class="menu">
	<ul>
		<li><a href="{if $smarty.const.ADMIN_MODE}./{else}./admin{/if}">Admin dashboard</a></li>
		<li><a href="{if $smarty.const.ADMIN_MODE}./?user{else}./admin/?user{/if}">Users</a></li>
		<ul>
			<li><a href="{if $smarty.const.ADMIN_MODE}./?user&amp;invite{else}./admin/?user&amp;invite{/if}">Invite user</a></li>
		</ul>
		<li><a href="{if $smarty.const.ADMIN_MODE}./?post{else}./admin/?post{/if}">Posts</a></li>
		<ul>
			<li><a href="{if $smarty.const.ADMIN_MODE}.{/if}./admin/?post&amp;add">Add post</a></li>
			<li><a href="#">Some more</a></li>
		</ul>
		<li><a href="{if $smarty.const.ADMIN_MODE}.{/if}./?user&amp;action=logout">Log out</a></li>
	</ul>
</div>