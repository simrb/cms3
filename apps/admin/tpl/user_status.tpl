<div class="show-table">
	<table>
		<thead>
			<tr>
				<th style="width:30px">id</th>
				<th style="width:200px"><?= l('user token'); ?></th>
				<th style="width:200px"><?= l('created time'); ?></th>
				<th style="width:200px"><?= l('timeout'); ?></th>
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
/*  						echo "<td><a href='?_m=user&view=edit&act=edit&uid=".$row["usid"]."'>编辑</a>  ";
  						echo "<a href='?_m=user&act=del&uid=".$row["uid"]."'>删除</a></td>";*/
  						echo "</tr>";
  					}
				}
			?>

		</tbody>
	</table>

	
</div>


<div class="show-bar">
	<form class="edit-form">
		<a href="?_r=user&_v=status&_a=delall"><input type="button" value="<?= l('clear all'); ?>" class="bgwt" /></a>
	</form>
</div>
