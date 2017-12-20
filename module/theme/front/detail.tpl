<div class="show-detail">
	<?php
		// record
		if (isset($t['record_res'])) {
			echo "<label class='left'>" .date('Y-m-d H:i:s', $t['record_res']['created']) . "</label>";
			echo "<label class='right'>". l('useful') ." " . $t['record_res']['useful'] . "</label>";
			echo "<pre class='clear'>" . show_bbcodes($t['record_res']['content']) . "</pre>";
		} else {
			echo "<pre class='clear'>" . l('no content in here') . "</pre>";
		}


		// picture
		if (isset($t['record_img'])) {
			echo "<div class='clear show-detail-img'><img src='" . 
				DIR_UPLOAD . $t['record_img'] . "'/></div>";
			echo '<br/>';
		}


		// comments
		if (isset($t["record_cmt"])) {
			while($row = mysql_fetch_array($t["record_cmt"])) {
				echo "<label class='left'>" . date('Y-m-d H:i:s', $row['created']) . "</label>";
				echo "<label class='right'>". l('useful') ." " . $row['useful'] . "</label>";
				echo "<pre class='clear'>" . show_bbcodes($row['content']) . "</pre>";
			}
		}

	?>
</div>


<?php if (isset($t['record_res'])) { ?>
<div class="edit-form">
	<form action="<?= $t['url'] ?>" method="post" >
		<ul>
			<li><textarea name="content" class="" placeholder="<?= l('say someing ...'); ?>" ></textarea></li>
			<li>
				<input type="submit" value="<?= l('submit'); ?>" class="" />
				<input type="hidden" name="rid" value="<?= $t["rid"] ?>" />
				<input type="hidden" name="cid" value="<?= $t["cid"] ?>" />
			</li>
		</ul>
	</form>
</div>
<?php } ?>
