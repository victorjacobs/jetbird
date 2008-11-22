<?php /* Smarty version 2.6.20, created on 2008-11-21 23:23:31
         compiled from admin.post.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucfirst', 'admin.post.tpl', 73, false),array('modifier', 'date_format', 'admin.post.tpl', 74, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="wrap">
	<div id="contentwrap">
		<div id="content">
			<h2>Jetbird - Admin</h2>
			<small>Manage Posts</small>
			
			<?php if (isset ( $_GET['new'] )): ?>
			<?php if (isset ( $this->_tpl_vars['post_error'] )): ?><p class="error"><b>Error:</b> Please fill in all the required fields correctly</p><?php endif; ?>
			<form name="input" action="./?post&amp;new" method="post">
				<p><table>
					<tr>
						<td><b>Title</b></td>
						<td><input type="text" name="post_title"<?php if (isset ( $this->_tpl_vars['post_data']['post_title'] )): ?> value="<?php echo $this->_tpl_vars['post_data']['post_title']; ?>
"<?php endif; ?> /></td>
					</tr>

					<tr>
						<td valign="top"><b>Text</b></td>
						<td><textarea rows="20" cols="55" name="post_content"><?php if (isset ( $this->_tpl_vars['post_data']['post_content'] )): ?><?php echo $this->_tpl_vars['post_data']['post_content']; ?>
<?php endif; ?></textarea></td>
					</tr>

					<tr>
						<td><b>Comments</b></td>
						<td>
							<select name="comment_status">
								<option value="open" selected>Open</option>
								<option value="closed">Closed</option>
							</select>
						</td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="submit" value="Post" /></td>
					</tr>
				</table></p>
			</form>
			<?php else: ?>
			<h3>Overview</h3>
			
			<p>
				<table width="100%">
					<tr>
						<td width="35%"><b>Title</b></td>
						<td><b>Author</b></td>
						<td><b>Date</b></td>
						<td><b>Comments</b></td>
						<td width="1">&nbsp;</td>
						<td width="1">&nbsp;</td>
					</tr>
					
					<?php $_from = $this->_tpl_vars['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
					<tr>						
						<td><a href="../?view&amp;id=<?php echo $this->_tpl_vars['post']['post_id']; ?>
"><?php echo $this->_tpl_vars['post']['post_title']; ?>
</a></td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['user_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y %H:%I") : smarty_modifier_date_format($_tmp, "%d/%m/%y %H:%I")); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['comment_status'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
						<td><a href="../?post&amp;edit&amp;id=<?php echo $this->_tpl_vars['post']['post_id']; ?>
">Edit</a></td>
						<td><a class="needs_confirmation" href="#" name="del_post_<?php echo $this->_tpl_vars['post']['post_id']; ?>
">Delete</a></td>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			</p>
			<?php endif; ?>
		</div>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>