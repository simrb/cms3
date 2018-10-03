
	<div class="edit-form">
		<form action="<?=url_c('_a=addip&_v=defence');?>" method="post">
			<ul>

				<li><label><?= l('add ip'); ?></label></li>
				<li>
					<input type="text" name="ip_name" value="" />
					<select name="ip_type">
						<?php
							foreach($t['ip_type'] as $k => $v) {
								echo '<option value="'. $k .'">'. l($v) .'</option>';
							}
						?>
					</select>
					<span><?=l('number')?> <?=$t['ip_num']?></span>
				</li>

				<li><label><?= l('add word'); ?></label></li>
				<li>
					<input type="text" name="word_name" value="" />
					<span><?=l('number')?> <?=$t['wd_num']?></span>
				</li>

				<li>
					<br>
					<input type="submit" value="<?= l('submit'); ?>" />
				</li>
			</ul>

		</form>
	</div>

