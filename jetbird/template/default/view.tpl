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
					<form name="input" action="post.php?action=make_comment&amp;post_id={$smarty.get.post_id}" method="post">
					text
					<textarea rows="10" cols="50" name="comments_text" ></textarea> <br />
					<input type="submit" value="Post"/>
					</form>
					</div>
					{/if}
					
			</div>		
		</div>
		<div id="wrap_footer">
		</div>	
	</div> 
	
</body>
</html>
	