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
			
			{if isset($upload_error)}<p class="error">Something went wrong processing your file. Please check it</p>{/if}
			{if isset($error_message)}<p class="error">{$error_message}</p>{/if}
			
			<p>
				<form enctype="multipart/form-data" action="./?file&amp;upload" method="post" id="upload_attachment">
					<input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}" />
					<input type="file" name="uploaded_file" />
					<input type="submit" name="upload" value="Upload"{if isset($error_message)} disabled{/if} />
				</form>
			</p>
			{else}
			<h3>Overview</h3>
			
			<p>
				<table width="100%">
					<tr>
						<td><b>File name</b></td>
						<td><b>Owner</b></td>
						<td width="100"><b>Date</b></td>
						<td width="1">&nbsp;</td>
					</tr>
					{foreach from=$attachments item=file}
					<tr>
						<td>{$file.attachment_original_name}</td>
						<td>{$file.user_name|ucfirst}</td>
						<td>{$file.attachment_date|date_format:"%d/%m/%y %H:%I"}</td>
						<td><a href="#" class="needs_confirmation" name="del_file_{$file.attachment_id}">Delete</a></td>
					</tr>
					{/foreach}
				</table>
			</p>
			{/if}
		</div>
	</div>
	
{include file="foot.tpl"}