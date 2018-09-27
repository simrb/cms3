<div class="show-detail">
	<?php
		// record
		if (isset($t['record_res'])) {
			echo '<div class="show-detail-body clear">';

			// created time, rid, uid
			echo "<div class='show-detail-title'><label class='left created' id='r" .$t['rid']. "' title='".
				date('Y/m/d H:i:s', $t['record_res']['created']) .", r#". $t['rid'] .", u#". $t['record_res']['uid'] ."'>". 
				timeago($t['record_res']['created']) .", by ". $t['record_res']['uid']. ",</label>";

			// useful
			$useful_class 	= 'useful_no';
			$useful_number 	= '';
			$useful_img 	= '13.png';
			if ($t['record_res']['useful'] > 0 ) {
				$useful_class 	= 'useful_hl';
				$useful_number 	= $t['record_res']['useful'];
				$useful_img 	= '12.png';
			}
			echo "<label class='left useful_view ".$useful_class."' use_url='?_a=ajax_useful&rid=".$t['rid']."'>".
				"<span>". $useful_number ."</span><img class='left' src='view/img/". $useful_img ."' /></label>";

			// reply
			echo "<label class='right re_btn' reply_sign='r#".$t['rid']." u#".$t['record_res']['uid']."'>". l('reply') . "</label>";

			if ($t['ulevel'] > 4 or $t['record_res']['uid'] == $t['uid']) {
				echo "<label class='right top_btn' rid=".$t['rid']." uid=".$t['record_res']['uid'].">". l('fresh') . "</label>";
			}

			if ($t['ulevel'] > 4) {
				// admin btn
				echo "<a class='adm_btn' href='#'><label class='right'>". l('admin') . "</label></a>";

				// move btn
				echo "<a class='mv_btn' href='#'><label class='right'>". l('move') . "</label></a>";

				// edit btn
				echo "<a class='edit_btn' href='?_m=admin&_f=record&_v=edit&rid=".$t['rid'].
						"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
			}

			// body pre
			echo "</div><pre class='clear' rid='". $t['rid'] ."'>" . parse_html($t['record_res']['content']) . "</pre>";
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
				$useful_class 	= 'useful_no';
				$useful_number 	= '';
				$useful_img 	= '13.png';
				if ($row['useful'] > 0 ) {
					$useful_class 	= 'useful_hl';
					$useful_number 	= $row['useful'];
					$useful_img 	= '12.png';
				}
				echo "<label class='left useful_view ".$useful_class."' use_url='?_a=ajax_useful&rid=".$row['rid']."'>".
					"<span>". $useful_number ."</span><img class='left' src='view/img/". $useful_img ."' /></label>";

				// reply
				echo "<label class='right re_btn' reply_sign='r#".$row['rid']." u#".$row['uid']."'>". l('reply') . "</label>";

				if ($t['ulevel'] > 4) {
					// admin btn
					echo "<a class='adm_btn' href='#'><label class='right'>". l('admin') . "</label></a>";

					// move btn
					echo "<a class='mv_btn' href='#'><label class='right'>". l('move') . "</label></a>";

					// edit btn
					echo "<a class='edit_btn' href='index.php?_m=admin&_f=record&_v=edit&rid=".$row['rid'].
							"' target='_blank'><label class='right'>". l('edit') . "</label></a>";
				}

				echo "</div><pre class='clear' rid='". $row['rid'] ."'>" . 
						parse_html($row['content']) . "</pre>";
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
				<a class="right upload_img" href="index.php?_v=upload" target="_blank"><?= l('upload') ?></a>
			</li>
		</ul>
	</form>
</div>
<?php } ?>
