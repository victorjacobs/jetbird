<?php /* Smarty version 2.6.20, created on 2008-12-21 19:50:44
         compiled from foot.tpl */ ?>
		<div id="sidewrap">
			<div class="menu">
				<ul>
					<li><a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./">Home</a></li>
					<li><a href="<?php if (@ADMIN_MODE): ?>../<?php endif; ?>#">Projects</a></li>
					<li><a href="<?php if (@ADMIN_MODE): ?>../<?php endif; ?>?about">About us</a></li>
					<li><a href="<?php if (@ADMIN_MODE): ?>../<?php endif; ?>#">Contact</a></li>
				</ul>
			</div>
			
			<div class="menu">
				<ul>
					<li>
						<form action="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./?search&amp;action=search" method="post">
							<input id="search" type="text" name="search" accesskey="f" size="24" />
						</form>
					</li>
				</ul>
			</div>
			
			<hr />
			<?php if (isset ( $_SESSION['login'] )): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin.menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
			
			<?php if (! isset ( $_SESSION['login'] )): ?>
			<div id="adsense">
				<img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/image/adsensemockup.gif" alt="" />
			</div><?php endif; ?>
		</div>
		
		<div id="footer">
			<small>Powered by <a href="http://jetbird.googlecode.com" target="_blank">Jetbird</a><?php if (! isset ( $_SESSION['login'] )): ?> &raquo; <a href="./?login">Log in</a><?php endif; ?><?php if (isset ( $this->_tpl_vars['queries'] )): ?> &raquo; Queries: <?php echo $this->_tpl_vars['queries']; ?>
<?php endif; ?></small>
		</div>
	</div>
	
</body>

</html>