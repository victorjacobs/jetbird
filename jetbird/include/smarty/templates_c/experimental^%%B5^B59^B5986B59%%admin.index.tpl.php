<?php /* Smarty version 2.6.20, created on 2008-11-22 21:05:05
         compiled from admin.index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin.index.tpl', 38, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Admin</h2>
				<small>Statistics</small>
				
				<h3>Recent comments</h3>
				
				<p>
					<table width="100%">
						<tr>
							<td width="100"><b>Date</b></td>
							<td><b>Post</b></td>
							<td><b>Author</b></td>
							<td width="40"><b>IP</b></td>
						</tr>
						
					<?php $_from = $this->_tpl_vars['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>	<tr>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['comment']['comment_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y %H:%I") : smarty_modifier_date_format($_tmp, "%d/%m/%y %H:%I")); ?>
</td>
							<td><a href="../?view&amp;id=<?php echo $this->_tpl_vars['comment']['comment_parent_post_id']; ?>
#comments"><?php echo $this->_tpl_vars['comment']['post_title']; ?>
</a></td>
							<td><?php if (! empty ( $this->_tpl_vars['comment']['comment_author_url'] )): ?><a href="<?php echo $this->_tpl_vars['comment']['comment_author_url']; ?>
" target="_blank"><?php endif; ?><?php echo $this->_tpl_vars['comment']['comment_author']; ?>
<?php if (isset ( $this->_tpl_vars['comment']['comment_author_url'] )): ?></a><?php endif; ?></td>
							<td><?php echo $this->_tpl_vars['comment']['comment_author_ip']; ?>
</td>
						</tr>
					<?php endforeach; endif; unset($_from); ?></table>
				</p>
			</div>
		</div>
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>