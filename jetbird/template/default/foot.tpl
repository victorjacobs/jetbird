				<div id="footer">
					<small>
					Powered by <a href="http://jetbird.googlecode.com" target="_blank">Jetbird</a>
					{if $smarty.const.SVN_REVISION ==! false} r{$smarty.const.SVN_REVISION}{/if}
					{if !isset($smarty.session.login)}
					&raquo; <a href="./?user&amp;action=login">Log in</a>
					{/if}
					{if isset($queries)} &raquo; Queries: {$queries}
					{/if}
					</small>
				</div> 