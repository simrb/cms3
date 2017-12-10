<?php if ($t['_v'] == 'show') { ?>

	<div class="show-query">
		<form action="<?=url_c('_a=query');?>" method="post">

			<input type="search" class="search" name="select_kw" placeholder="<?= l('keyword'); ?>" />
			<select name="select_field" class="selectmenu">
				<option value="rid" ><?= l('id'); ?></option>
				<option value="uid" ><?= l('user id'); ?></option>
				<option value="cid" ><?= l('category'); ?></option>
				<option value="useful" ><?= l('useful'); ?></option>
			</select>
			<select name="select_type" class="selectmenu">
				<option value="exact" ><?= l('accurate'); ?></option>
				<option value="vague" ><?= l('vague'); ?></option>
			</select>
			<input type="submit" class="" value="<?= l('query'); ?>" />

		</form>
	</div>

	<div class="show-table">
		<table>
			<thead>
				<tr>
					<th style="width:40px">id</th>
					<th style="width:40px"><?= l('uid'); ?></th>
					<th style="width:40px"><?= l('category'); ?></th>
					<th style="width:40px"><?= l('follow id'); ?></th>
					<th style="width:40px"><?= l('useful'); ?></th>
					<th style="width:180px"><?= l('content'); ?></th>
				<!--	<th style="width:110px">创建时间</th>	-->
					<th style="width:80px"></th>
				</tr>
			</thead>

			<tbody>

				<?php
					if ($t["record_res"]) {
						while($row = mysql_fetch_array($t["record_res"])) {

							$category = isset($t['category_kv'][$row['cid']]) ? $t['category_kv'][$row['cid']] : " -- ";
						//$status = isset($t['status_kv'][$row['sid']]) ? $t['status_kv'][$row['sid']] : "";


							echo "<tr>";

	  						echo "<td><a href='?_v=detail&rid=". $row["rid"]. 
								"' target='_blank'> > </a>";
	  						echo "<span>". $row["rid"] ."</span>";
	  						echo "<a href='". url_c("_v=edit&rid=".
	  							$row["rid"]). "'> > </a></td>";

							echo "<td>" . $row['uid'] . "</td>";
							echo "<td>" . $category . "</td>";
							//echo "<td>" . $level . "</td>";
	  						echo "<td>" . $row['follow'] . "</td>";
	  						echo "<td>" . $row['useful'] . "</td>";

	  						echo "<td><a title='".l('edit')."' href='". url_c("_v=edit&rid=".
	  							$row["rid"]). "'>". utf8_substr($row['content'],0,20) . "</a></td>";

	  					//	echo "<td>" . $row['created'] . "</td>";

	  						echo "<td><a href='?_v=detail&rid=". $row["rid"]. 
								"' target='_blank'>". l('see') ."</a>";
	  					//	echo "<td><a href='". url_c("_a=del&rid=".
	  					//		$row["rid"]). "'>". l('delete') ."</a></td>";

	  						echo "</tr>";
	  					}
					}
				?>

			</tbody>
		</table>

		<p class="pagination">
			<?php
				if ($t["pagenums"] > 0) {
					for ($i=0; $i < $t["pagenums"]; $i++) {
						$j = $i + 1;
						echo "<span> <a href='". url_c("pagecurr=$j");
						echo "'>$j</a> </span>";
					}
				}

			?>
		</p>


	</div>

	<div class="pagination_label">
		<span><?= l('record count'); ?>：<?=$t["res_num"] ?>, </span>
		<span><?= l('current page'); ?>：<?=$t["pagecurr"] ?> / <?=$t["pagenums"] ?></span>
	</div>



<?php } ?>


<?php if ($t['_v'] == 'edit') { ?>

	<div class="edit-form">
		<form action="<?=url_c('_a='.$t['_a']);?>" method="post" >
			<ul>
				<li><label><?= l('content'); ?></label></li>
				<li><textarea name="content" class="record_text file_input" ><?= $t['content'] ?></textarea></li>

				<li>

					<?php
						if (isset($t['category_kv'])) {
							echo '<label>'. l('category') .'</label>';

							echo '<select name="cid">';
							echo '<option value="0"> -- </option>';
							foreach ($t['category_kv'] as $key => $val) {

								// $defval = ($key == $t["cid"]) ? 'checked="checked"' : "";
								// echo '<label class="radio"><input '.$defval
								// 	.' name="cid" type="radio" value="'.$key
								// 	.'" />'. $val .'</label>';

								$defval = ($key == $t["cid"]) ? 'selected="selected"' : "";
								echo '<option '.$defval.' value="'
									.$key.'">'. $val .'</option>';
							}
							echo '</select>';

						}
					?>

				</li>
				<li>
					</br>
					<input type="submit" value="<?= l('submit'); ?>" class="" />
					<input type="hidden" name="rid" value="<?= $t["rid"] ?>" />

				</li>
			</ul>

			</br>
			<label class="showorhide"><a href="#"><?= l('more options'); ?> >>> </a></label>
			<div>
				</br>
				
				<ul>
					<li>
						<label><?= l('picture'); ?></label>
						<div class="file_list"></div>
					</li>

					<li>
						<label><?= l('follow'); ?></label>
						<input type="text" name="follow" class="w50" value="<?= $t['follow'] ?>" />
					</li>
					<li>
						<label><?= l('useful'); ?></label>
						<input type="text" name="useful" class="w50" value="<?= $t['useful'] ?>" />
					</li>
					<li>
						<?php if ($t['rid'] != 0) { ?>
							<a href="<?= url_c('_a=del&rid='. $t['rid']); ?>">
								<button > <?= l('delete'); ?> </button>
							</a>
						<?php } ?>
					</li>
				</ul>

			</div>
			
			
		</form>
	</div>

<?php } ?>


<link rel="stylesheet" type="text/css" href="<?= path_theme('css/record.css') ?>">
<script type="text/javascript" src="<?= path_theme('js/file.js') ?>"></script>
