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
				<li><a href="./">Home</a></li>
				<li><a href="#">Projects</a></li>
				<li><a href="./?about">About us</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
		</div>
		
		{if isset($smarty.session.login)}
		<div class="menu">
			<ul>
				<li><a href="./admin/">Admin panel</a></li>
			</ul>
		</div>{/if}