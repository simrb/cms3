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
			</li>

			<li><input type="submit" value="<?= l('submit'); ?>"></li>

			<li><br />
					<pre><?=show_bbcode($t['aboutpost']); ?></pre>
			</li>
		</ul>
	</form>
</div>

