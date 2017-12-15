<?php if ($t['_v'] == 'show') { ?>

	<div class="show-bar">
		<form class="edit-form">
			<a href="<?= url_c('_v=edit'); ?>"><input type="button" value="<?= l('add'); ?>" class="bgwt" /></a>
		</form>
	</div>
	<div class="show-table">
		<table >
			<thead>
				<tr>
					<th style="width:80px">id</th>
					<th style="width:80px"><?= l("category"); ?></th>
					<th style="width:80px"><?= l("follow"); ?></th>
					<th style="width:80px"><?= l("order"); ?></th>
					<th style="width:80px"></th>
				</tr>
			</thead>

			<tbody>

				<?php
					if ($t["category_res"]) {
						while($row = mysql_fetch_array($t["category_res"])) {
							echo "<tr>";
	  						echo "<td><a href='". url_c("_a=edit&_v=edit&cid=".$row["cid"]) .
									"'>". $row["cid"] ." > </a></td>";
	  						echo "<td><a href='". url_c("_a=edit&_v=edit&cid=".$row["cid"]) .
									"'>". $row["name"] ."</a></td>";
	  						echo "<td>" . $row['follow'] . "</td>";
	  						echo "<td>" . $row['number'] . "</td>";
	  						echo "<td><a href='". url_c("_a=del&cid=". $row["cid"]) .
									"'>". l('delete') ."</a></td>";
	  						echo "</tr>";
	  					}
					}
				?>

			</tbody>
		</table>

	</div>


<?php } ?>



<?php if ($t['_v'] == 'edit') { ?>

	<div class="edit-form">
		<form action="<?=url_c('_a='.$t['_a']);?>" method="post">
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
