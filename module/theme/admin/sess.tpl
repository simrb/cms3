
<div class="show-bar">
	<form class="edit-form">
		<a href="<?=url_c('_v=status&_a=delsess');?>"><input type="button" value="<?= l('clean all'); ?>" class="bgwt" /></a>
		<a href="<?=url_c('_v=status&_a=delsess&exp=y');?>"><input type="button" value="<?= l('clean expired'); ?>" class="bgwt" /></a>
	</form>
</div>

<div class="show-table">
	<table>
		<thead>
			<tr>
				<th style="width:30px">uid</th>
				<th style="width:200px"><?= l('user token'); ?></th>
				<th style="width:200px"><?= l('created time'); ?></th>
				<th style="width:200px"><?= l('expired time'); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php
				if ($t["user_res"]) {
					while($row = mysql_fetch_array($t["user_res"])) {
						echo "<tr>";
  						echo "<td>" . $row['uid'] . "</td>";
  						echo "<td>" . $row['token'] . "</td>";
  						echo "<td>" . date('Y-m-d', $row['created']) . "</td>";
  						echo "<td>" . date('Y-m-d', $row['exptime']) . "</td>";
  						echo "</tr>";
  					}
				}
			?>

		</tbody>
	</table>

</div>

