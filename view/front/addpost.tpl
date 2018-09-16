<div class="edit-form vaild-form">
	<form action="?_a=<?= $t['_a'] ?>" method="post" name="upload" >
		<ul>
			<li>
				<?php
					if (isset($t['category_kv'][$t['cid']])) {
						echo '<p class="title_des">'. $t['category_kv'][$t['cid']]['descript'] .'</p>';
					}
				?>
			</li>
			<li>
				<textarea name="content" class="record_text file_input"></textarea>
				<input type="hidden" name="cid" value="<?=$t['cid']?>" />
				<a class="right upload_img" href="?_v=upload" target="_blank"><?= l('upload') ?></a>
			</li>

			<li><input type="submit" value="<?= l('submit'); ?>"></li>

			<li><br />
					<pre><?=parse_html($t['aboutpost']); ?></pre>
			</li>
		</ul>
	</form>
</div>

