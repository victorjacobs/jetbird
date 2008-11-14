		<div id="wrap_menu">
			
			<a href="./">Home</a> <br />
			{if !isset($smarty.session.login)}
			<a href="./?user&amp;action=login">Login</a>
			{else}
			<a href="./?user&amp;action=logout">Logout</a>
			{/if}
		</div>