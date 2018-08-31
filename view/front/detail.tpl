<div class="show-detail">
	<?php
		$user_level	= user_level();

		// record
		if (isset($t['record_res'])) {
			echo '<div class="show-detail-body clear">';

			// created time, rid, uid
			echo "<div class='show-detail-title'><label class='left created' id='r" .$t['rid']. "' title='".
				date('Y/m/d H:i:s', $t['record_res']['created']) .", r#". $t['rid'] .", u#". $t['record_res']['uid'] ."'>". 
				timeago($t['record_res']['created']) .", by ". $t['record_res']['uid']. ",</label>";

			// useful
			$useful_class = $t['record_res']['useful'] > 0 ? 'useful_hl' : 'useful_no';
			echo "<label class='left useful_view ".$useful_class."'>". l('useful') ."</label>";

			// reply
			echo "<label class='right re_btn' reply_sign='r#".$t['rid']." u#".$t['record_res']['uid']."'>". l('reply') . "</label>";

			if ($user_level > 4) {
				// admin btn
				echo "<a class='adm_btn' href='#'><label class='right'>". l('admin') . "</label></a>";

				// useful btn
				echo "<a href='?_a=useful&rid=".$t['rid'].
						"'><label class='right useful_btn' rid=".$t['rid']." >". l('useful') . "</label></a>";

				// move btn
				echo "<a class='mv_btn' href='#'><label class='right'>". l('move') . "</label></a>";

				// rm btn
				//echo "<a class='del_btn' href='?_a=delpost&rid=".$t['rid'].
				//		"'><label class='right'>". l('delete') . "</label></a>";

				// edit btn
				echo "<a class='edit_btn' href='?_m=admin&_f=record&_v=edit&rid=".$t['rid'].
						"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
			}

			// body pre
			echo "</div><pre class='clear' rid='". $t['rid'] ."'>" . show_bbcode($t['record_res']['content']) . "</pre>";
			echo '</div>';
		} else {
			echo "<pre class='clear'>" . l('no content in here') . "</pre>";
		}


		// comments
		if (isset($t["record_cmt"])) {
			while($row = mysql_fetch_array($t["record_cmt"])) {
				echo '<div class="show-detail-body clear">';

				// created time, rid, uid
				echo "<div class='show-detail-title'><label class='left created' id='r" .$row['rid']. "' title='".
					date('Y/m/d H:i:s', $row['created']) .", r#". $row['rid'] .", u#". $row['uid'] ."'>". 
					timeago($row['created']) .", by ". $row['uid']. ",</label>";

				// useful
				$useful_class = $row['useful'] > 0 ? 'useful_hl' : 'useful_no';
				echo "<label class='left useful_view ".$useful_class."'>". l('useful') ."</label>";

				// reply
				echo "<label class='right re_btn' reply_sign='r#".$row['rid']." u#".$row['uid']."'>". l('reply') . "</label>";

				if ($user_level > 4) {
					// admin btn
					echo "<a class='adm_btn' href='#'><label class='right'>". l('admin') . "</label></a>";

					// useful btn
					echo "<a href='?_a=useful&cmt=".$row['rid']. "&rid=". $t['rid'].
							"'><label class='right useful_btn' rid=".$row['rid'].">". l('useful'). "</label></a>";

					// move btn
					echo "<a class='mv_btn' href='#'><label class='right'>". l('move') . "</label></a>";

					// rm btn
					//echo "<a class='del_btn' href='?_a=delpost&cmt=".$row['rid']. "&rid=". $t['rid'].
					//		"'><label class='right'>". l('delete') . "</label></a>";

					// edit btn
					echo "<a class='edit_btn' href='?_m=admin&_f=record&_v=edit&rid=".$row['rid'].
							"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
				}

				echo "</div><pre class='clear' rid='". $row['rid'] ."'>" . show_bbcode($row['content']) . "</pre>";
				echo '</div>';
			}
		}

	?>
</div>


<?php if (isset($t['record_res'])) { ?>
<div class="edit-form vaild-form">
	<form action="<?= $t['url'] ?>" method="post" >
		<ul>
			<li><textarea name="content" class="reply_txt" placeholder="<?= l('say someing ...'); ?>" ></textarea></li>
			<li>
				<input type="submit" value="<?= l('submit'); ?>" class="" />
				<input type="hidden" name="rid" value="<?= $t["rid"] ?>" />
				<input type="hidden" name="cid" value="<?= $t["cid"] ?>" />
				<a class="right upload_img" href="?_v=upload" target="_blank"><?= l('upload') ?></a>
			</li>
		</ul>
	</form>
</div>
<?php } ?>
