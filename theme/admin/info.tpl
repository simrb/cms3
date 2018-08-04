
	<div class="edit-form">
		<form action="<?=url_c('_a=edit&_v=info');?>" method="post">
			<ul>

				<li><label><?= l('logo picture'); ?></label></li>
				<li>
					<input type="text" name="web_logo" value="<?= $t["web_logo"] ?>" />
				</li>

				<li><label><?= l('header or name'); ?></label></li>
				<li>
					<input type="text" name="web_header" value="<?= $t["web_header"] ?>" />
				</li>

				<li><label><?= l('default title'); ?></label></li>
				<li>
					<input class="w100" type="text" name="web_title" value="<?= $t["web_title"] ?>" />
				</li>

				<li><label><?= l('website description'); ?></label></li>
				<li>
					<input class="w100" type="text" name="web_des" value="<?= $t["web_des"] ?>" />
				</li>

				<li>
					<br>
					<input type="hidden" name="" value="" />
					<input type="submit" value="<?= l('update'); ?>" />
				</li>
			</ul>

		</form>
	</div>
