<?php if ($t['_v'] == 'show') { ?>

	<div class="show-bar">
		<form class="edit-form">
			<a href="<?= url_c('_v=edit'); ?>"><input type="button" value="<?= l('add'); ?>" class="bgwt" /></a>
		</form>
	</div>

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
	  						echo "<td>" . date('Y-m-d', $row['created']) . "</td>";
	  						echo "<td><a href='". url_c("_a=del&fid=".
	  								$row['fid']). "'>". l('delete') ."</a></td>";
	  						echo "</tr>";
	  					}
					}
				?>

			</tbody>
		</table>

		<div class="pagination">
			<form action="<?=url_c();?>" method="post">
				<input type="submit" value="<?=l('go to');?>" class="goto" />
				<input type="text" name="pagecurr" class="pagecurr" value="<?=$t['pagecurr']?>" /> / <?=$t["pagenums"]?>
				<span><?=l('pages');?>,  <?=$t["res_num"]?> <?=l('records');?></span>
			</form>
		</div>

	</div>


<?php } ?>


<?php if ($t['_v'] == 'edit') { ?>

	<div class="edit-form">

		<form name="upload" action="<?=url_c('_a=add');?>" enctype="multipart/form-data" method="post">
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
