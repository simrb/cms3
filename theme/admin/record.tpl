<?php if ($t['_v'] == 'show') { ?>

	<div class="show-query">
		<form action="<?=url_c('_a=query');?>" method="post">
			<a href="<?= url_c('_v=edit'); ?>"><input type="button" value="<?= l('add'); ?>" class="bgwt" /></a>

			<input type="search" class="search" name="select_kw" placeholder="<?= l('keyword'); ?>" />
			<select name="select_field" class="selectmenu">
				<option value="rid" ><?= l('id'); ?></option>
				<option value="uid" ><?= l('uid'); ?></option>
				<option value="cid" ><?= l('category'); ?></option>
				<option value="useful" ><?= l('rate'); ?></option>
				<option value="tag" ><?= l('tag'); ?></option>
			</select>

			<input type="submit" value="<?= l('query'); ?>" />
			<!--
			<select name="select_type" class="selectmenu">
				<option value="exact" ><?= l('accurate'); ?></option>
				<option value="vague" ><?= l('vague'); ?></option>
			</select>
			-->

		</form>
	</div>


	<div class="show-table">
		<table>
			<thead>
				<tr>
					<th style="width:40px">id</th>
					<th style="width:180px"><?= l('content'); ?></th>
					<th style="width:40px"><?= l('category'); ?></th>
					<th style="width:40px"><?= l('uid'); ?></th>
					<th style="width:40px"><?= l('parent'); ?></th>
					<th style="width:40px"><?= l('rate'); ?></th>
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
								"' target='_blank'>";
	  						echo "<span>". $row["rid"] ."</span>";
	  						echo " > </a></td>";

	  						echo "<td><a title='".l('edit')."' href='". url_c("_v=edit&rid=".
	  							$row["rid"]). "'>". htmlspecialchars(utf8_substr($row['content'],0,20)) . "</a></td>";

							echo "<td>" . $category . "</td>";
							echo "<td>" . $row['uid'] . "</td>";
							//echo "<td>" . $level . "</td>";
	  						echo "<td>" . $row['follow'] . "</td>";
	  						echo "<td>" . $row['useful'] . "</td>";


	  						//	echo "<td>" .date('Y-m-d', $row['created']). "</td>";
	  						//	echo "<td><a href='?_v=detail&rid=". $row["rid"]. 
							//	"' target='_blank'>". l('see') ."</a>";

	  						echo "<td><a href='". url_c("_a=del&rid=".
	  							$row["rid"]). "'>". l('trash') ."</a></td>";

	  						echo "</tr>";
	  					}
					}
				?>

			</tbody>
		</table>

		<div class="pagination">
			<form action="<?=url_c();?>" method="post">
				<a href="<?=url_c('pagecurr=1');?>"><?=l('first page')?></a>
				<span>, </span>
				<a href="<?=url_c('pagecurr='. ($t['pagecurr'] - 1) );?>"><?=l('prev page')?></a>
				<span>, </span>
				<a href="<?=url_c('pagecurr='. ($t['pagecurr'] + 1) );?>"><?=l('next page')?></a>
				<span>, </span>
				<a href="<?=url_c('pagecurr='.$t['pagenums']);?>"><?=l('last page')?></a>
				<span>, </span>
				<input type="submit" value="<?= l('go to');?>" class="goto" />
				<input type="text" name="pagecurr" class="pagecurr" value="<?=$t['pagecurr']?>" /> / <?=$t["pagenums"]?>
				<span><?=l('pages');?>,  <?=$t["res_num"]?> <?= l('records1');?></span>
			</form>
		</div>

	</div>




<?php } 


if ($t['_v'] == 'edit') { ?>

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
			<label class="showorhide"><a href="#"><?= l('more'); ?> >>> </a></label>
			<div>
				</br>
				
				<ul>
					<li>
						<label><?= l('tag'); ?></label>
						<input type="text" name="tag" class="w100" value="<?= $t['tag'] ?>" />
					</li>

					<li>
						<label><?= l('picture'); ?></label>
						<div class="file_list"></div>
					</li>

					<li>
						<label><?= l('parent'); ?></label>
						<input type="text" name="follow" class="w50" value="<?= $t['follow'] ?>" />
					</li>
					<li>
						<label><?= l('rate'); ?></label>
						<input type="text" name="useful" class="w50" value="<?= $t['useful'] ?>" />
					</li>
					<li>
						<?php if ($t['rid'] != 0) { ?>
							<a href="<?= url_c('_a=del&rid='. $t['rid']); ?>">
								<button > <?= l('trash'); ?> </button>
							</a>
						<?php } ?>
					</li>
				</ul>

			</div>
			
			
		</form>
	</div>


<?php } 


if ($t['_v'] == 'optimize') { ?>

		<form action="<?=url_c('_a=optimize');?>" method="post">

			<select name="select_condition" class="selectmenu">
				<option selected> <?= l('condition'); ?> </option>
				<option value="clean_trash" ><?= l('clean trash'); ?></option>
				<option value="clean_guest" ><?= l('clean guest records three months ago'); ?></option>
				<option value="clean_useless" ><?= l('clean useless records three months ago'); ?></option>
				<option value="clean_guest_and_useless" ><?= l('clean guest and useless three months ago'); ?></option>
				<option value="clean_guest_and_useless_days" ><?= l('clean guest and useless in three days'); ?></option>
			</select>

			<input type="submit" value="<?= l('execute'); ?>" />

		</form>

<?php } ?>


<script type="text/javascript" src="<?= path_theme('js/file.js') ?>"></script>
