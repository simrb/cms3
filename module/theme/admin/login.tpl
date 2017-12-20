<div class="edit-form edit-form-login">
	<form action="<?=url_c('_a=login');?>" method="post">
		<ul>

			<?php if (isset($_GET['firstime'])) { ?>
				<input type="hidden" name="firstime" />

				<li><h3><?= l('user register'); ?></h3></li>

				<li><label><?= l('username'); ?></label></li>
				<li><input type="text" name="username" /></li>

				<li><label><?= l('password'); ?></label></li>
				<li><input type="text" name="password" /></li>

				<li><label><?= l('invite code'); ?></label></li>
				<li><input type="text" name="invitecode" /></li>

				<li>
					<input type="submit" value="<?= l('confirm'); ?>" class="" />
				</li>

				<li>
					<br />
					<a href="?_v=detail&rid=2" target="_blank">
						<?= l('register have to know') ?></a>
				</li>

			<?php } else { ?>

				<li><h3><?= l('user login'); ?></h3></li>
				<li><label><?= l('username'); ?></label></li>
				<li>
					<input type="text" name="username" />
				</li>

				<li><label><?= l('password'); ?></label></li>
				<li>
					<input type="text" name="password" />
				</li>	

				<li>
					<input type="submit" value="<?= l('confirm'); ?>" class="" />
				</li>

				<li>
					<br />
					<a href="<?=$t['link_login']?>&firstime=yes" >
						<?= l('register account, please check here') ?></a>
				</li>

			<?php } ?>

		</ul>
	</form>
</div>


