<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Jetbird</title>
	<link rel="stylesheet" href="{$template_dir}/css/style.css" type="text/css" media="screen" />
	<link href="./feed/" rel="alternate" type="application/rss+xml" title="Jetbird RSS Feed" />
</head>

<body style="background: url({$template_dir}/image/blue_flower/bg.jpg) repeat-y top center #AAAAAA fixed;">

	<div id="page">

		<div id="topbar">
			<div class="alignleft">&nbsp;&nbsp;&nbsp;Server load: {$server_load}</div>
			{if $smarty.session.login}Logged in as {$smarty.session.user_name|ucfirst} &raquo; <a href="./admin/">Admin panel</a>| <a href="./?logout">Log out</a>{else}<a href="./?login">Log in</a>{/if}
		</div>

	<div id="header">
		<div id="headerimg" style="background-image: url({$template_dir}/image/blue_flower/head.jpg);">
			<h1><a href="./">Jetbird</a></h1>
			<div class="description">The everyday annoyances of two geeks</div>
		</div>
	</div>

	<div id="pagebar" style="background: url({$template_dir}/image/blue_flower/pagebar.jpg);">
		<li class="page_item"><a href="./">Home</a></li>
		<li class="page_item"><a href="#">Projects</a></li>
		<li class="page_item"><a href="#">About</a></li>
		<li class="page_item"><a href="#">Contact</a></li>
		<li class="page_item"><a href="#">Archives</a></li>
	</div>

	<div id="grad" style="height: 65px; width: 100%; background: url({$template_dir}/image/blue_flower/topgrad.jpg);">
		&nbsp;
	</div>