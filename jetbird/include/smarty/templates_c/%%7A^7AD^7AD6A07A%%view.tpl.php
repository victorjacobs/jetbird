<?php /* Smarty version 2.6.20, created on 2008-09-15 17:40:42
         compiled from view.tpl */ ?>
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
			<?php if ($this->_tpl_vars['view'] === FALSE): ?>
				invalid link, please return to the homepage
			<?php else: ?>
				
					
					<p class="main_title">
					<?php echo $this->_tpl_vars['view_title']; ?>

					</p>
					
					<p class="main_date">
					<?php echo $this->_tpl_vars['view_date']; ?>

					</p>
					<br />
					
					<p class="main_post">
					<?php echo $this->_tpl_vars['view_post']; ?>
 
					</p>
					
					
					<hr />
					<br />

			<?php endif; ?>
					<p class="comments">
						<?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['comment']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<?php echo $this->_tpl_vars['username'][$this->_sections['loop']['index']]; ?>

								<br />
								<?php echo $this->_tpl_vars['comment'][$this->_sections['loop']['index']]; ?>

								<br />
								<br />
						<?php endfor; endif; ?>
					</p>
					

					<?php if ($_SESSION['login'] == 1): ?>
					<div id="view_post_box">
					<form name="input" action="post.php?action=make_comment&amp;post_id=<?php echo $_GET['post_id']; ?>
" method="post">
					text
					<textarea rows="10" cols="50" name="comments_text" ></textarea> <br />
					<input type="submit" value="Post"/>
					</form>
					</div>
					<?php endif; ?>
					
			</div>		
		</div>
		<div id="wrap_footer">
		</div>	
	</div> 
	
</body>
</html>
	