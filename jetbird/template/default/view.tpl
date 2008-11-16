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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Jetbird Preview</title>
	<link type="text/css" rel="stylesheet" media="screen" href="{$template_dir}/css/style.css" />
</head>

<body>
	<div id="wrap_main">
	
		{include file="head.tpl"}
		
		<div id="wrap_content">
			<div class="post">
			
				<div class="title">
				{$view_title}
				</div>
				
				<div class="author">
				By {$author|ucfirst} on {$view_date}
				</div>
				
				<p>{$view_post}</p>	
				
			</div>
			
			<h2> Comments </h2>
			<div id="wrap_comments">	
			
			{if !isset($comment) and $comment_status == "closed"}
				<p>Comments closed</p>
			{else}
			
			{if isset($comment)}
				{section name=loop loop=$comment}
					<div class="comments">
						{$comment[loop]}
					</div>
				{/section}
				
			{else}
				<p>No comments yet, be the first to write one!</p>	
			{/if}
			
			
			
			<br />
				<h3>Add comment{if $smarty.session.user_level == 1 and $comment_status == "closed"} (closed){/if}</h3>
				
				{if $smarty.session.user_level == 1 or $comment_status == "open"}
				{if isset($comment_error)}<p class="error"><b>Error:</b> Please fill in all the required fields correctly</p>{/if}
					<form action="./?post&amp;comment&amp;id={$smarty.get.id}" method="post">
					<table>	
						
						<tr>	
							<td><b><small>Name (required):</small></b></td>
							<td><input type="text" name="author"{if isset($comment_data.author)} value="{$comment_data.author}"{/if} /> </td>
						</tr>	
						
						<tr>	
							<td><b><small>Mail (required, won't be shown in public)</small></b></td>
							<td><input type="text" name="email"{if isset($comment_data.email)} value="{$comment_data.email}"{/if} /></td>
						</tr>	
							
						
						<tr>	
							<td><b><small>Website</small></b></td>
							<td><input type="text" name="website"{if isset($comment_data.website)} value="{$comment_data.website}"{/if} /></td>
						</tr>
						
						</table>
						<table>
						<tr>
							<td> <textarea rows="10" cols="40" name="comment">{if isset($comment_data.comment)}{$comment_data.comment}{/if}</textarea> </td>
						</tr>
						
						<tr>
							<td><input type="submit" name="submit" value="Send" /></td>
						</td>
						</table>
					</form>
				{else}
				<p>Comments closed</p>
				{/if}
				{/if}
			</div>
			{include file="foot.tpl"}
		</div>
		{include file="menu.tpl"}		
	</div>

		
</body>
</html>
	