<?php if ($t['_v'] == 'show') { ?>

	<div class="show-table">
		<table >
			<thead>
				<tr>
					<th style="width:80px">id</th>
					<th style="width:80px"><?= l("category"); ?></th>
					<th style="width:80px"><?= l("follow"); ?></th>
					<th style="width:80px"><?= l("number"); ?></th>
					<th style="width:80px"></th>
				</tr>
			</thead>

			<tbody>

				<?php
					if ($t["category_res"]) {
						while($row = mysql_fetch_array($t["category_res"])) {
							echo "<tr>";
	  						echo "<td><a href='". url("_edit_edit&cid=".$row["cid"]) .
									"'>". $row["cid"] ." > </a></td>";
	  						echo "<td><a href='". url("_edit_edit&cid=".$row["cid"]) .
									"'>". $row["name"] ." > </a></td>";
	  						echo "<td>" . $row['follow'] . "</td>";
	  						echo "<td>" . $row['number'] . "</td>";
	  						echo "<td><a href='". url("_del&cid=".$row["cid"]) .
									"'>". l('delete') ."</a></td>";
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
						echo "<span> <a href='". url("&pagecurr=$j&". $t["url"]);
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

	<div class="show-bar">
		<form class="edit-form">
			<a href="<?= url('__edit'); ?>">
				<input type="button" value="<?= l('add'); ?>" class="bgwt" />
			</a>
		</form>
	</div>

<?php } ?>



<?php if ($t['_v'] == 'edit') { ?>

	<div class="edit-form">
		<form action="<?= url(); ?>" method="post">
			<ul>

				<li><label><?= l("category name"); ?></label></li>
				<li>
					<input type="text" name="category_name" value="<?= $t["category_name"] ?>" />
				</li>

				<li><label><?= l("follow"); ?></label></li>
				<li>
					<input type="text" name="follow" value="<?= $t["follow"] ?>" />
				</li>

				<li><label><?= l("number"); ?></label></li>
				<li>
					<input type="text" name="number" value="<?= $t["number"] ?>" />
				</li>

				<li>
					<br>
					<input type="hidden" name="cid" value="<?= $t["cid"] ?>" />
					<input type="submit" value="<?= l("submit"); ?>" class="" />
				</li>
			</ul>

		</form>
	</div>

<?php } ?>
