<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> blog pre-alpha v0.03 </title>
	<link type="text/css" rel="stylesheet" media="screen" href="template/default/css/style.css" />

</head>

<body>
	<div id="wrap_main">
	
		<div id="wrap_header">
			<div id="header">
			{if !isset($smarty.session.login)}
			<a class="link_login" href="user.php?action=login"> login</a>
			<a class="link_login" href="user.php?action=register"> register </a>
			{else}
			<a class="link_login" href="user.php?action=logout"> logout</a>
			you are logged in as: {$smarty.session.username}
			{/if}
			
			{if $smarty.session.auth_id == 1}
			<a class="link_login" href="post.php?action=main_make_post"> post</a>
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
					
					<a class="link_view" href="view.php?action=view_post&amp;post_id={$post_id[loop]}"> read more</a>
					{if $smarty.session.auth_id == 1}
					<a class="link_edit" href="post.php?action=main_edit_post&amp;post_id={$post_id[loop]}"> edit</a>
					{/if}
					<br />
					<hr />
					<br />
			{/section}
			
				
			</div>
		</div>
		
		<div id="wrap_footer">
		this is some text3
		</div>
		
	</div> 
	
</body>
</html>
	