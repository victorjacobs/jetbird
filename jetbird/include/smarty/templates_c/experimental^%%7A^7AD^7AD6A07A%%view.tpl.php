<?php /* Smarty version 2.6.20, created on 2008-12-05 20:46:08
         compiled from view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucfirst', 'view.tpl', 27, false),array('modifier', 'date_format', 'view.tpl', 27, false),array('modifier', 'bbcode', 'view.tpl', 29, false),array('modifier', 'nl2br', 'view.tpl', 29, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Blog</h2>
				<small>The everyday problems of two geeks.</small>
				
				<h3><?php echo $this->_tpl_vars['post']['post_title']; ?>
</h3>
				<small class="subtitle">By <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['user_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 on <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y") : smarty_modifier_date_format($_tmp, "%d/%m/%y")); ?>
</small>
				
				<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['post']['post_content'])) ? $this->_run_mod_handler('bbcode', true, $_tmp) : BBCode($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>
				
				<?php if ($_SESSION['user_level'] == 1): ?><p>
					<small>
						<a href="./?post&amp;edit&amp;id=<?php echo $_GET['id']; ?>
">Edit</a> | <a href="#" class="needs_confirmation" name="del_post_<?php echo $_GET['id']; ?>
">Delete</a>
					</small>
				</p><?php endif; ?>
				
				<h3 id="comments">Comments<?php if ($this->_tpl_vars['post']['comment_status'] == 'closed' && $_SESSION['user_level'] == 1): ?> - Closed<?php endif; ?></h3>
				<?php if (! $this->_tpl_vars['comments'] && $this->_tpl_vars['post']['comment_status'] == 'closed' && $_SESSION['user_level'] != 1): ?>
				<p>Comments closed</p>
				<?php else: ?>
				<?php if (isset ( $this->_tpl_vars['comments'] )): ?>
				<?php $_from = $this->_tpl_vars['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
				<div class="comment">
					<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['comment']['comment_content'])) ? $this->_run_mod_handler('bbcode', true, $_tmp) : BBCode($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>
					<p><small><?php echo $this->_tpl_vars['comment']['comment_author']; ?>
 on <?php echo ((is_array($_tmp=$this->_tpl_vars['comment']['comment_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y %H:%I") : smarty_modifier_date_format($_tmp, "%d/%m/%y %H:%I")); ?>
</small></p>
				</div>
				<?php endforeach; endif; unset($_from); ?>
				<?php else: ?>
				<p>No comments yet, be the first to write one!</p>
				<?php endif; ?>
				<h3 id="add_comment">Add comment<?php if ($_SESSION['user_level'] == 1 && $this->_tpl_vars['comment_status'] == 'closed'): ?> (closed)<?php endif; ?></h3>
				<?php if ($_SESSION['user_level'] == 1 || $this->_tpl_vars['post']['comment_status'] == 'open'): ?>
				<?php if (isset ( $this->_tpl_vars['comment_error'] )): ?><p class="error"><b>Error:</b> Please fill in all the required fields correctly</p><?php endif; ?>
				<form action="./?post&amp;comment&amp;id=<?php echo $_GET['id']; ?>
" method="post">
					<div>
						<input type="text" name="author"<?php if (isset ( $this->_tpl_vars['comment_data']['author'] )): ?> value="<?php echo $this->_tpl_vars['comment_data']['author']; ?>
"<?php endif; ?> />
						<b><small>Name (required)</small></b>
					</div>
					
					<div>
						<input type="text" name="email"<?php if (isset ( $this->_tpl_vars['comment_data']['email'] )): ?> value="<?php echo $this->_tpl_vars['comment_data']['email']; ?>
"<?php endif; ?> />
						<b><small>Mail (required, won't be shown in public)</small></b>
					</div>
					
					<div>
						<input type="text" name="website"<?php if (isset ( $this->_tpl_vars['comment_data']['website'] )): ?> value="<?php echo $this->_tpl_vars['comment_data']['website']; ?>
"<?php endif; ?> />
						<b><small>Website</small></b>
					</div>
					
					<div>
						<textarea rows="10" cols="40" name="comment"><?php if (isset ( $this->_tpl_vars['comment_data']['comment'] )): ?><?php echo $this->_tpl_vars['comment_data']['comment']; ?>
<?php endif; ?></textarea>
					</div>
					
					<div>
						<input type="submit" name="submit" value="Send" />
					</div>
				</form>
				<?php else: ?>
				<p>Comments closed</p>
				<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>