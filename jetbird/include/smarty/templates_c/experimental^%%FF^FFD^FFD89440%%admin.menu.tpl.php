<?php /* Smarty version 2.6.20, created on 2008-12-21 19:50:51
         compiled from admin.menu.tpl */ ?>
<div class="menu">
				<ul>
					<li>
						<a href="<?php if (@ADMIN_MODE): ?>./<?php else: ?>./admin<?php endif; ?>">Admin dashboard</a>
					</li>
					<li>
						<a href="<?php if (@ADMIN_MODE): ?>./?user<?php else: ?>./admin/?user<?php endif; ?>">Users</a>
					</li>
					<ul>
						<li><a href="<?php if (@ADMIN_MODE): ?>./?user&amp;invite<?php else: ?>./admin/?user&amp;invite<?php endif; ?>">Invite user</a></li>
						<li><a href="<?php if (@ADMIN_MODE): ?>./?user&amp;generate<?php else: ?>./admin/?user&amp;invite<?php endif; ?>">Generate key</a></li>
					</ul>
					<li>
						<a href="<?php if (@ADMIN_MODE): ?>./?post<?php else: ?>./admin/?post<?php endif; ?>">Posts</a>
					</li>
					<ul>
						<li>
							<a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./admin/?post&amp;new">New post</a>
						</li>
					</ul>
					
					<li>
						<a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./admin/?file">Attachments</a>
					</li>
					<ul>
						<li>
							<a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./admin/?file&amp;upload">Upload file</a>
						</li>
						<li>
							<a href="#">Bla</a>
						</li>
					</ul>
					
					<li>
						<a href="<?php if (@ADMIN_MODE): ?>.<?php endif; ?>./?logout">Log out</a>
					</li>
				</ul>
			</div>