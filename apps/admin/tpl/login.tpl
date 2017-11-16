<div class="edit-form edit-form-login">
	<form action="?_r=user&_a=login" method="post">

		<ul>
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
				<input type="submit" value="<?= l('enter'); ?>" class="" />
			</li>

			<li>
				<br/>
				
				<label for="firstime"> <span>* </span>
					<?= l('register account, please check here') ?>
					<input id="firstime" type="checkbox" name="firstime" value="yes" />
				</label>
				
			</li>

			<li>
				<span>* </span>
				<a href="?_v=detail&rid=2" target="_blank">
					<?= l('register have to know') ?></a>
			</li>

		</ul>

	</form>
</div>


