<?php /* Smarty version 2.6.20, created on 2008-12-15 20:48:56
         compiled from admin.user.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin.user.tpl', 133, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div id="wrap">
		<div id="contentwrap">
			<div id="content">
				<h2>Jetbird - Admin</h2>
				<small>Manage users</small>
				
				<?php if (isset ( $_GET['invite'] )): ?>
				<h3>Invite user</h3>
				<p>
					<form action="./?user&amp;add_user" method="post">
						<table>
							<tr>
								<td>Email address</td>
								<td><input type="text" name="email" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" name="submit" value="Send" /></td>
							</tr>
						</table>
					</form>
				</p>
				<?php elseif (isset ( $_GET['edit'] )): ?>
				<h3>Edit User</h3>
				<?php if (isset ( $this->_tpl_vars['edit_error'] )): ?><p class="error"><b>Error:</b> Please fill in all the required fields correctly</p><?php endif; ?>
				<p>
					<form action="./?user&amp;edit&amp;id=<?php echo $_GET['id']; ?>
" method="post">
						<table>
							<tr>
								<td><b>Username</b></td>
								<td><input type="text" name="user_name" value="<?php echo $this->_tpl_vars['user']['0']['user_name']; ?>
" /></td>
							</tr>
							
							<tr>
								<td><b>Userlevel</b></td>
								<td>
									<select disabled>
										<option>Owner</option>
										<option>Moderator</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td><b>Email</b></td>
								<td><input type="text" name="user_mail" value="<?php echo $this->_tpl_vars['user']['0']['user_mail']; ?>
" /></td>
							</tr>
							
							<tr>
								<td><b>New password</b></td>
								<td><input type="password" name="pass" /></td>
							</tr>
							
							<tr>
								<td><b>Retype password</b></td>
								<td><input type="password" name="pass_confirm" /></td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Update" name="submit" /></td>
							</tr>
						</table>
					</form>
				</p>
				<?php elseif (isset ( $_GET['generate'] )): ?>
				<p>
					<h3>Generate registration keys</h3>
					<?php if (! isset ( $this->_tpl_vars['keys'] )): ?>
					<?php if (isset ( $this->_tpl_vars['generate_error'] )): ?><p class="error"><b>Error:</b> Please fill in all the required fields correctly</p><?php endif; ?>
					<form action="./?user&amp;generate" method="post">
						<p>
							<table>
								<tr>
									<td><b>Number</b></td>
									<td><input type="text" name="key_count" value="1" /></td>
								</tr>

								<tr>
									<td>&nbsp;</td>
									<td><input type="submit" name="submit" value="Create" /></td>
								</tr>
							</table>
						</p>
					</form>
					<?php else: ?>
					<p>Following keys were created:</p>
					<ul>
					<?php $_from = $this->_tpl_vars['keys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key']):
?>
						<li><?php echo $this->_tpl_vars['key']; ?>
</li>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
					<?php endif; ?>
				</p>
				<?php elseif (isset ( $_GET['delete'] )): ?>
				<p><b>Error:</b> Don't use this in this template</p>
				<?php else: ?>
				<h3>Overview</h3>
				<p>
					<table width="100%">
						<tr>
							<td><b>ID</b></td>
							<td width="100"><b>Name</b></td>
							<td><b>Mail</b></td>
							<td><b>Last login</b></td>
							<td width="1">&nbsp;</td>
							<td width="1">&nbsp;</td>
						</tr>
						<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['user']['user_id']; ?>
</td>
							<td><?php echo $this->_tpl_vars['user']['user_name']; ?>
</td>
							<td><?php echo $this->_tpl_vars['user']['user_mail']; ?>
</td>
							<td><?php if (! $this->_tpl_vars['user']['user_last_login']): ?><i>Never</i><?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user_last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y %H:%I") : smarty_modifier_date_format($_tmp, "%d/%m/%y %H:%I")); ?>
<?php endif; ?></td>
							<td><a href="./?user&amp;edit&amp;id=<?php echo $this->_tpl_vars['user']['user_id']; ?>
">Edit</a></td>
							<td><a href="#" class="needs_confirmation" name="del_user_<?php echo $this->_tpl_vars['user']['user_id']; ?>
">Delete</a></td>
						</tr>
						<?php endforeach; endif; unset($_from); ?>
					</table>
				</p>
				<p><a href="./?user&amp;action=new_user">Add user</a> | <a href="#">Display deleted users</a></p>
				
				<h3>Inactivated register keys</h3>
				<p>
					<table width="100%">
						<tr>
							<td width="150"><b>Key</b></td>
							<td><b>Sent to</b></td>
							<td width="96"><b>Created on</b></td>
						</tr>
						<?php $_from = $this->_tpl_vars['keys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['key']['user_reg_key']; ?>
</td>
							<td><?php if (empty ( $this->_tpl_vars['key']['user_mail'] )): ?><i>No one</i><?php else: ?><?php echo $this->_tpl_vars['key']['user_mail']; ?>
<?php endif; ?></td>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['key']['user_last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y %H:%I") : smarty_modifier_date_format($_tmp, "%d/%m/%y %H:%I")); ?>
</td>
						</tr>
						<?php endforeach; endif; unset($_from); ?>
					</table>
				</p>
				<p>
					<a href="./?user&amp;generate">Generate keys</a>
				</p>
				<?php endif; ?>
			</div>
		</div>
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>