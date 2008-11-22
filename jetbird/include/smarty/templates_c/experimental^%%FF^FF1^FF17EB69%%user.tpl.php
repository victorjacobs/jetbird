<?php /* Smarty version 2.6.20, created on 2008-11-22 21:05:01
         compiled from user.tpl */ ?>

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
				<?php if (! isset ( $_SESSION['login'] )): ?>
				<?php if ($this->_tpl_vars['login'] === FALSE): ?>
				<p class="error"><b>Error:</b> password or username wrong, please try again.</p>
				<?php endif; ?>
				<form name="input" action="./?user&amp;action=login" method="post">
					<table>
						<tr>
							<td><b>Username</b></td>
							<td><input type="text" name="username" /></td>
						</tr>
						
						<tr>
							<td><b>Password</b></td>
							<td><input type="password" name="password"></td>
						</tr>
						
						<tr>
							<td><b>Remind me</b></td>
							<td><input type="checkbox" name="rememberlogin" disabled /></td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" value="Login" /></td>
						</tr>
					</table>
				</form>
				<?php elseif (isset ( $_SESSION['login'] ) && ! isset ( $_POST['username'] )): ?>
				<p><b>Error:</b> you are already logged in</p>
				<?php endif; ?>
			</div>
		</div>
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>