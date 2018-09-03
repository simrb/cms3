<div class="edit-form edit-form-login show-user">
	<form action="?_v=settings&_a=settings" method="post">
		<ul>
			<li>
				<a href="?_v=message"><h3 class="user-msg gray1"><?= l('user message'); ?></h3></a>
				<a href="?_v=settings"><h3 class="user-info black"><?= l('user info'); ?></h3></a>
			</li>

			<li class='clear'><label><?= l('user id'); ?></label></li>
			<li>
				<input type="text" value="#<?= user_id(); ?>" disabled="disabled" />
			</li>

			<li><label><?= l('username'); ?></label></li>
			<li>
				<input type="text" value="<?= user_name(); ?>" disabled="disabled" />
			</li>

			<li><label><?= l('password'); ?></label></li>
			<li>
				<input type="text" name="password" value="**" />
			</li>

			<li><label><?= l('nickname'); ?></label></li>
			<li>
				<input type="text" name="nickname" value="<?= $t['nickname']; ?>" />
				<input type="hidden" name="nickname_old" value="<?= $t['nickname']; ?>" />
			</li>

			<li><label><?= l('contact'); ?></label></li>
			<li>
				<input type="text" name="contact" value="<?= $t['contact']; ?>" />
				<input type="hidden" name="contact_old" value="<?= $t['contact']; ?>" />
			</li>

			<li><label><?= l('introduction'); ?></label></li>
			<li>
				<textarea name="intro" ><?= $t['intro']; ?></textarea>
				<textarea name="intro_old" class="hide" style="display:none;"><?= $t['intro']; ?></textarea>
			</li>

			<li>
				<input type="submit" value="<?= l('save'); ?>" class="" />
			</li>
		</ul>

	</form>
</div>
