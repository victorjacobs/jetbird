<div class="menu">
	<ul>
		<li><a href="{if $smarty.const.ADMIN_MODE}./{else}./admin{/if}">Admin dashboard</a></li>
		<li><a href="{if $smarty.const.ADMIN_MODE}./?user{else}./?user{/if}">Users</a></li>
		<li><a href="{if $smarty.const.ADMIN_MODE}.{/if}./?user&amp;action=logout">Log out</a></li>
	</ul>
</div>