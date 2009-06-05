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
					<li><a href="./">Home</a></li>
					<li><a href="#">Projects</a></li>
					<li><a href="./?about">About us</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</div>
			
			<div class="menu">
				<ul>
					<li>
						<form action="./?search&amp;action=search" method="post">
							<input id="search" type="text" name="search" accesskey="f" size="24" />
						</form>
					</li>
				</ul>
			</div>
			
			<hr />
			{if isset($smarty.session.login)}
			<div class="menu">
				<ul>
					<li>
						<a href="./admin/">Admin panel</a>
					</li>
				</ul>
			</div>{/if}
			
			{if !isset($smarty.session.login)}
			<div id="adsense">
				<img src="{$template_dir}/image/adsensemockup.gif" alt="" />
			</div>{/if}
		</div>
		
		<div id="footer">
			<small>Powered by <a href="http://jetbird.googlecode.com" target="_blank">Jetbird</a>{if !isset($smarty.session.login)} &raquo; <a href="./?login">Log in</a>{/if}{if isset($queries)} &raquo; Queries: {$queries}{/if}</small>
		</div>
	</div>
	
</body>

</html>