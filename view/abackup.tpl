<div class="show-bar">
	<form class="edit-form">
		<a href="<?=url_c('_v=backup&_a=clean_bak');?>"><input type="button" value="<?= l('clean all'); ?>" class="bgwt" /></a>

		<a href="<?=url_c('_v=backup&_a=output_topic');?>"><input type="button" value="<?= l('output topic'); ?>" class="bgwt" /></a>
	</form>
</div>

<div class="show-table">
	<table>
		<thead>
			<tr>
				<th style="width:200px"><?= l('file'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if ($t["bak_res"]) {
					foreach($t["bak_res"] as $key => $val) {
						echo "<tr>";
  						echo "<td><a href='".$val."' target='_blank'>" . $val . "</a></td>";
  						echo "</tr>";
  					}
				}
			?>
		</tbody>
	</table>

</div>


