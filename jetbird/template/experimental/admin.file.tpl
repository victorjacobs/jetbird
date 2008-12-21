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
			<small>Manage attachments</small>
			
			{if isset($smarty.get.upload)}
			<h3>Upload attachment</h3>
			
			<p>
				<form enctype="multipart/form-data" action="./?file&amp;upload" method="post" id="upload_attachment">
					<input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}" />
					<input type="file" name="uploaded_file" />
					<input type="submit" name="upload" value="Upload" />
				</form>
			</p>
			{else}
			<h3>Overview</h3>
			{/if}
		</div>
	</div>
	
{include file="foot.tpl"}