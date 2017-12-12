
<div class="show-bar">
	<form class="edit-form">
		<a href="<?=url_c('_v=status&_a=delall');?>"><input type="button" value="<?= l('clear all'); ?>" class="bgwt" /></a>
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
<!-- 				<th style="width:80px"></th> -->
			</tr>
		</thead>

		<tbody>

			<?php
				if ($t["user_res"]) {
					while($row = mysql_fetch_array($t["user_res"])) {
						echo "<tr>";
  						echo "<td>" . $row['uid'] . "</td>";
  						echo "<td>" . $row['token'] . "</td>";
  						echo "<td>" . $row['created'] . "</td>";
  						echo "<td>" . $row['exptime'] . "</td>";
/*  					echo "<td><a href='?_m=admin&_f=user&_v=edit&_a=edit&uid=".$row["sid"]."'>编辑</a>  ";
  						echo "<a href='?_m=admin&_f=user&_a=del&uid=".$row["uid"]."'>删除</a></td>";
*/
  						echo "</tr>";
  					}
				}
			?>

		</tbody>
	</table>

</div>

