<div class="edit-form edit-form-login vaild-form">
	<form action="<?=$t['action_url'];?>" method="post">
		<ul>

			<?php if (isset($_GET['firstime']) AND $t['user_reg_open'] == 'on') { ?>
				<input type="hidden" name="firstime" />

				<li><h3><?= l('user register'); ?></h3></li>

				<li><label><?= l('username'); ?></label></li>
				<li><input type="text" name="username" /></li>

				<li><label><?= l('password'); ?></label></li>
				<li><input type="text" name="password" /></li>

				<?php if ($t['user_icode_open'] == 'on') { ?>
					<li><label><?= l('invite code'); ?></label></li>
					<li><input type="text" name="invitecode" /></li>
				<?php }?>

				<?php if ($t['user_vcode_open'] == 'on') { ?>
					<li><label><?= l('valid code'); ?></label></li>
						<input class='shot_vcode' type="text" name="shot_vcode" />
						<img class="vcode_img" src="" />
					</li>
				<?php }?>

				<li><br /><input type="submit" value="<?= l('confirm'); ?>" /></li>

				<li><br />
					<a href="<?=$t['link_login']?>" >
						<?= l('return login') ?></a>
				</li>

			<?php } else { ?>

				<li><h3><?= l('user login'); ?></h3></li>

				<li><label><?= l('username'); ?></label></li>
				<li><input type="text" name="username" /></li>

				<li><label><?= l('password'); ?></label></li>
				<li><input type="text" name="password" /></li>

				<?php if ($t['user_vcode_open'] == 'on') { ?>
					<li><label><?= l('valid code'); ?></label></li>
					<li>
						<input class='shot_vcode' type="text" name="shot_vcode" />
						<img class="vcode_img" src="" />
					</li>
				<?php }?>

				<li><br /><input type="submit" value="<?= l('confirm'); ?>" /></li>

				<?php if($t['user_reg_open'] == 'on') { ?>
					<li><br />
						<a href="<?=$t['link_register']?>" >
							<?= l('register account, please check here') ?></a>
					</li>

				<?php } ?>

			<?php } ?>

				<li>
					<pre><?= $t['aboutuser']; ?></pre>
				</li>

		</ul>
	</form>
</div>


