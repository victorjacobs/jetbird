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
			<div id="menu">
				<ul>
					<li><a href="./">Home</a></li>
					<li><a href="#">Projects</a></li>
					<li><a href="#">About us</a></li>
					<li><a href="#">Contact</a></li>
					{if isset($smarty.session.login)}<li><a href="./admin">Control panel</a></li>
					<li><a href="./?user&amp;action=logout">Log out</a></li>{/if}
				</ul>
			</div>
			<hr />

			<!-- <div id="adsense">
				<img src="image/adsensemockup.gif" alt="" />
			</div> -->
		</div>
		
		<div id="footer">
			<small>Powered by <a href="http://jetbird.googlecode.com" target="_blank">Jetbird</a>{if !isset($smarty.session.login)} &raquo; <a href="./?user&amp;action=login">Log in</a>{/if}</small>
		</div>
	</div>
	
</body>

</html>