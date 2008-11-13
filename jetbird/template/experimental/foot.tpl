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
		<div id="sidewrap">
			<div class="menu">
				<ul>
					<li><a href="{if $smarty.const.ADMIN_MODE}.{/if}./">Home</a></li>
					<li><a href="{if $smarty.const.ADMIN_MODE}../{/if}#">Projects</a></li>
					<li><a href="{if $smarty.const.ADMIN_MODE}../{/if}#">About us</a></li>
					<li><a href="{if $smarty.const.ADMIN_MODE}../{/if}#">Contact</a></li>
				</ul>
			</div>
			
			<div class="menu">
				<ul>
					<li>
						<form action="#" method="post">
							<input id="search" type="text" name="search" accesskey="f" size="24" />
						</form>
					</li>
				</ul>
			</div>
			
			<hr />
			{if isset($smarty.session.login)}{include file="admin.menu.tpl"}{/if}
			
			{if !isset($smarty.session.login)}
			<div id="adsense">
				<img src="{$template_dir}/image/adsensemockup.gif" alt="" />
			</div>{/if}
		</div>
		
		<div id="footer">
			<small>Powered by <a href="http://jetbird.googlecode.com" target="_blank">Jetbird</a>{if $smarty.const.SVN_REVISION ==! false} r{$smarty.const.SVN_REVISION}{/if}{if !isset($smarty.session.login)} &raquo; <a href="./?user&amp;action=login">Log in</a>{/if}{if isset($queries)} &raquo; Queries: {$queries}{/if}</small>
		</div>
	</div>
	
</body>

</html>