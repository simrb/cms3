<?php if ($t['_v'] == 'show') { ?>

	<div class="show-table" >
		<table>
			<thead >
				<tr>
					<th style="width:80px"><?= l('picture'); ?></th>
					<th style="width:80px"><?= l('user id'); ?></th>
					<th style="width:80px"><?= l('file name'); ?></th>
					<th style="width:80px"><?= l('path'); ?></th>
					<th style="width:80px"><?= l('time'); ?></th>
					<th style="width:80px"></th>
				</tr>
			</thead>

			<tbody>

				<?php
					if ($t["file_res"]) {
						while($row = mysql_fetch_array($t["file_res"])) {
							echo "<tr>";
							echo "<td><a target='_blank' href='". DIR_UPLOAD .
									$row['path'] ."'><img height=20 width=20 src='".
									DIR_UPLOAD . $row['path'] ."' /></a></td>";
							echo "<td>" . $row['uid'] . "</td>";
	  						echo "<td>" . $row['name'] . "</td>";
	  						echo "<td>" . $row['path'] . "</td>";
	  						echo "<td>" . $row['created'] . "</td>";
	  						echo "<td><a href='". url_c("_del&fid=".
	  								$row["fid"]."). "'>". l('delete') ."</a></td>";
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

	<div class="show-bar">
		<form class="edit-form">
			<a href="<?= url_c('_v=edit'); ?>"><input type="button" value="<?= l('add'); ?>" class="bgwt" /></a>
		</form>
	</div>

<?php } ?>


<?php if ($t['_v'] == 'edit') { ?>

	<div class="edit-form">

		<form name="upload" action="<?=url_c('_a=add&_v=edit');?>" enctype="multipart/form-data" method="post">
			<ul>
				<li><input type="file" name="files[]"></li>
				<li><input type="file" name="files[]"></li>
				<li><input type="file" name="files[]"></li>
				<li><input type="file" name="files[]"></li>
				<li><input type="file" name="files[]"></li>

		  		<li><input type="submit" value="<?= l('submit'); ?>"></li>
		  	</ul>
		</form>

	</div>

<?php } ?>
