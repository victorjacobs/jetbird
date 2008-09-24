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
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div id="wrap_main">
	
		<div id="wrap_header">
			<div id="header">
			{if !isset($smarty.session.login)}
			<a class="link_login" href="./?user&amp;action=login"> login</a>
			<a class="link_login" href="./?user&amp;action=register"> register </a>
			{else}
			<a class="link_login" href="./?user&amp;action=logout"> logout</a>
			you are logged in as: {$smarty.session.username}
			{/if}
			
			{if $smarty.session.auth_id == 1}
			<a class="link_login" href="./?post&amp;action=main_make_post"> post</a>
			<a class="link_login" href="./admin/"> control</a>
			{/if}
			</div>
		</div>
		
		<div id="wrap_content">
			<div id="content">
			

			{section name=loop loop=$main_post}
					
					<p class="main_title">
					{$main_title[loop]} 
					</p>
					
					<p class="main_date">
					{$main_date[loop]}
					</p>
					<br />
					
					
					
					<p class="main_post">
					{$main_post[loop]} 
					</p>					
					
					<a class="link_view" href="./?view&amp;id={$post_id[loop]}"> read more</a>
					{if $smarty.session.auth_id == 1}
					<a class="link_edit" href="./?post&amp;action=main_edit_post&amp;post_id={$post_id[loop]}"> edit</a>
					{/if}
					<br />
					<hr />
					<br />
			{/section}
			
				
			</div>
		</div>
		
		<div id="wrap_footer">
		Number of queries: {$queries}
		</div>
		
	</div> 
	
</body>
</html>
	