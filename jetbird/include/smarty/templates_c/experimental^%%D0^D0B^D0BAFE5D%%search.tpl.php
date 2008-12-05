<?php /* Smarty version 2.6.20, created on 2008-11-22 23:37:15
         compiled from search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucfirst', 'search.tpl', 29, false),array('modifier', 'date_format', 'search.tpl', 29, false),array('modifier', 'truncate', 'search.tpl', 31, false),array('modifier', 'nl2br', 'search.tpl', 31, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="wrap">
	<div id="contentwrap">
		<div id="content">
			<h2>Jetbird - Search</h2>
			<small>Search results</small>
			
			<?php if (isset ( $this->_tpl_vars['results'] )): ?>
			<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
			<h3><?php echo $this->_tpl_vars['result']['post_title']; ?>
</h3>
			<small class="subtitle">By <?php echo ((is_array($_tmp=$this->_tpl_vars['result']['user_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 on <?php echo ((is_array($_tmp=$this->_tpl_vars['result']['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y") : smarty_modifier_date_format($_tmp, "%d/%m/%y")); ?>
</small>
			
			<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['result']['post_content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 500) : truncate($_tmp, 500)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>
			<p><small>
				<a href="./?view&amp;id=<?php echo $this->_tpl_vars['result']['post_id']; ?>
">Read more</a><?php if ($_SESSION['user_level'] == 1): ?> | <a href="./?post&amp;edit&amp;id=<?php echo $this->_tpl_vars['result']['post_id']; ?>
">Edit</a><?php endif; ?>

			</small></p><?php endforeach; endif; unset($_from); ?>
			<?php else: ?>
			<p>No search results</p>
			<?php endif; ?>
		</div>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>