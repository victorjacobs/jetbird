<?php /* Smarty version 2.6.20, created on 2008-09-15 21:33:58
         compiled from index.tpl */ ?>
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
			<?php if (! isset ( $_SESSION['login'] )): ?>
			<a class="link_login" href="user.php?action=login"> login</a>
			<a class="link_login" href="user.php?action=register"> register </a>
			<?php else: ?>
			<a class="link_login" href="user.php?action=logout"> logout</a>
			you are logged in as: <?php echo $_SESSION['username']; ?>

			<?php endif; ?>
			
			<?php if ($_SESSION['auth_id'] == 1): ?>
			<a class="link_login" href="post.php?action=main_make_post"> post</a>
			<?php endif; ?>
			</div>
		</div>
		
		<div id="wrap_content">
			<div id="content">
			

			<?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['main_post']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
					
					<p class="main_title">
					<?php echo $this->_tpl_vars['main_title'][$this->_sections['loop']['index']]; ?>
 
					</p>
					
					<p class="main_date">
					<?php echo $this->_tpl_vars['main_date'][$this->_sections['loop']['index']]; ?>

					</p>
					<br />
					
					
					
					<p class="main_post">
					<?php echo $this->_tpl_vars['main_post'][$this->_sections['loop']['index']]; ?>
 
					</p>					
					
					<a class="link_view" href="view.php?action=view_post&amp;post_id=<?php echo $this->_tpl_vars['post_id'][$this->_sections['loop']['index']]; ?>
"> read more</a>
					<?php if ($_SESSION['auth_id'] == 1): ?>
					<a class="link_edit" href="post.php?action=main_edit_post&amp;post_id=<?php echo $this->_tpl_vars['post_id'][$this->_sections['loop']['index']]; ?>
"> edit</a>
					<?php endif; ?>
					<br />
					<hr />
					<br />
			<?php endfor; endif; ?>
			
				
			</div>
		</div>
		
		<div id="wrap_footer">
		this is some text3
		</div>
		
	</div> 
	
</body>
</html>
	