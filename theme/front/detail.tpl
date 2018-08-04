<div class="show-detail">
	<?php
		$user_level	= user_level();

		// record
		if (isset($t['record_res'])) {
			echo "<label class='left'>" .date('Y-m-d H:i:s', $t['record_res']['created']) . "</label>";

			if ($user_level > 5) {
				echo "<a href='?_a=useful&rid=".$t['rid'].
						"'><label class='right'>". l('rate') ." " . 
						$t['record_res']['useful'] . "</label></a>";

				echo "<a class='del_btn' href='?_a=delpost&rid=".$t['rid'].
						"'><label class='right'>". l('delete') . "</label></a>";
				echo "<a class='edit_btn' href='?_m=admin&_f=record&_v=edit&rid=".$t['rid'].
						"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
			} else {
				echo "<label class='right'>". l('rate') ." " . $t['record_res']['useful'] . "</label>";
			}

			echo "<pre class='clear' rid='". $t['rid'] ."'>" . show_bbcodes($t['record_res']['content']) . "</pre>";
		} else {
			echo "<pre class='clear'>" . l('no content in here') . "</pre>";
		}


		// comments
		if (isset($t["record_cmt"])) {
			while($row = mysql_fetch_array($t["record_cmt"])) {
				echo "<label class='left'>" . date('Y-m-d H:i:s', $row['created']) . "</label>";

				if ($user_level > 5) {
					echo "<a href='?_a=useful&cmt=".$row['rid']. "&rid=". $t['rid'].
							"'><label class='right'>". l('rate') ." " . 
							$row['useful'] . "</label></a>";

					echo "<a class='del_btn' href='?_a=delpost&cmt=".$row['rid']. "&rid=". $t['rid'].
							"'><label class='right'>". l('delete') . "</label></a>";
					echo "<a class='edit_btn' href='?_m=admin&_f=record&_v=edit&rid=".$row['rid'].
							"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
				} else {
					echo "<label class='right'>". l('rate') ." " . $row['useful'] . "</label>";
				}

				echo "<pre class='clear' rid='". $row['rid'] ."'>" . show_bbcodes($row['content']) . "</pre>";
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
