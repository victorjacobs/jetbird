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
	<title>Jetbird Preview</title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div id="wrap_main">
		<div id="wrap_header">
			<div id="header">
			
			
			</div>
		</div>
		<div id="wrap_content">			
			<div id="content">
			{if $view === FALSE}
				invalid link, please return to the homepage
			{else}
				
					
					<p class="main_title">
					{$view_title}
					</p>
					
					<p class="main_date">
					{$view_date}
					</p>
					<br />
					
					<p class="main_post">
					{$view_post} 
					</p>
					
					
					<hr />
					<br />

			{/if}
					<p class="comments">
						{section name=loop loop=$comment}
								{$username[loop]}
								<br />
								{$comment[loop]}
								<br />
								<br />
						{/section}
					</p>
					

					{if $smarty.session.login == 1}
					<div id="view_post_box">
					<form name="input" action="./?post&action=make_comment&amp;post_id={$smarty.get.post_id}" method="post">
					text
					<textarea rows="10" cols="50" name="comments_text" ></textarea> <br />
					<input type="submit" value="Post"/>
					</form>
					</div>
					{/if}
					
			</div>		
		</div>
		<div id="wrap_footer">
		Number of queries: {$queries}
		</div>	
	</div> 
	
</body>
</html>
	