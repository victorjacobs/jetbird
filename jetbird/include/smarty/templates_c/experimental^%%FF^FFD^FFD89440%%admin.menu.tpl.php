<?php /* Smarty version 2.6.20, created on 2008-11-21 23:23:31
         compiled from admin.menu.tpl */ ?>
<div class="menu">
				<ul>
					<li><a href="<?php if (@ADMIN_MODE): ?>./<?php else: ?>./admin<?php endif; ?>">Admin dashboard</a></li>
					<li><a href="<?php if (@ADMIN_MODE): ?>./?user<?php else: ?>./admin/?user<?php endif; ?>">Users</a></li>
					<ul>
						<li><a href="<?php if (@ADMIN_MODE): ?>./?user&amp;invite<?php else: ?>./admin/?user&amp;invite<?php endif; ?>">Invite user</a></li>
						<li><a href="<?php if (@ADMIN_MODE): ?>./?user&amp;generate<?php else: ?>./admin/?user&amp;invite<?php endif; ?>">Generate key</a></li>
					</ul>
					<li><a href="<?php if (@ADMIN_MODE): ?>./?post<?php else: ?>./admin/?post<?php endif; ?>">Posts</a></li>
					<ul>
						<li><a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./admin/?post&amp;new">New post</a></li>
						<li><a href="#">Some more</a></li>
					</ul>
					<li><a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./?user&amp;action=logout">Log out</a></li>
				</ul>
			</div>