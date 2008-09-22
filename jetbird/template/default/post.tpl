{*This file is part of jetbird.

    jetbird is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> blog pre-alpha v0.03 </title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div id="wrap_main">
	
		<div id="wrap_header">
		</div>
		
		<div id="wrap_content">
				<div id="content">
				
				{if $smarty.get.action == main_make_post && $smarty.session.auth_id == 1}
				<form name="input" action="post.php?action=main_make_post" method="post">
				title
				<textarea rows="2.5" cols="50" name="main_title" ></textarea>  <br />
				text
				<textarea rows="10" cols="50" name="main_text" ></textarea> <br />
				<input type="submit" value="Post"/>
				</form>
	
				{elseif $smarty.get.action == main_edit_post && $smarty.session.auth_id == 1}
				<form name="input" action="post.php?action=main_edit_post&amp;post_id={$smarty.get.post_id}" method="post">
				title
				<textarea rows="2.5" cols="50" name="main_title" ></textarea>  <br />
				text
				<textarea rows="10" cols="50" name="main_text" ></textarea> <br />
				<input type="submit" value="Post"/>
				</form>
				{else}
				You do not have the required authorisation to perform this action.
				{/if}
				
				</div>
		</div>
		
		<div id="wrap_footer">
		</div>
		
	</div> 
	
</body>
</html>
	