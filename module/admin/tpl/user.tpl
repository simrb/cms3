<?php if ($t['_v'] == 'show') { ?>

	<div class="show-query">

		<form action="<?=url_c();?>" method="post">
			<input type="search" class="search" name="select_val" />
			<select name="select_key" class="selectmenu">
				<option value="uid" ><?= l('user id'); ?></option>
				<option value="username" ><?= l('username'); ?></option>
				<option value="level" ><?= l('level'); ?></option>
			</select>
			<input type="submit" class="" value="<?= l('query'); ?>" />

		</form>
	</div>

	<div class="show-table">
		<table>
			<thead>
				<tr>
					<th style="width:80px">id</th>
					<th style="width:80px"><?= l('name'); ?></th>
					<th style="width:80px"><?= l('level'); ?></th>
					<th style="width:80px"></th>
				</tr>
			</thead>

			<tbody>

				<?php
					if ($t["user_res"]) {
						while($row = mysql_fetch_array($t["user_res"])) {
							echo "<tr>";
	  						echo "<td><a href='". url_c("_v=edit&_a=edit&uid=".
	  							$row["uid"]). "'>". $row["uid"] ." > </a></td>";
	  						echo "<td><a href='". url_c("_v=edit&_a=edit&uid=".
	  							$row["uid"]). "'>". $row["username"] ."</a></td>";
	  						echo "<td>" . $row['level'] . "</td>";
	  						echo "<td><a href='". url_c('_a=del&uid='.$row["uid"]).
	  							"'>". l('delete') ."</a></td>";
	  						echo "</tr>";
	  					}
					}
				?>

			</tbody>
		</table>

		
	</div>


	<div class="show-bar">
		<form class="edit-form">
			<a href="<?=url_c('_v=edit');?>"><input type="button" value="<?= l('add'); ?>" class="bgwt" /></a>
		</form>
	</div>

<?php } ?>


<?php if ($t['_v'] == 'edit') { ?>


	<div class="edit-form">
		<form action="<?=url_c();?>" method="post">
			<ul>

				<li><label><?= l('username'); ?></label></li>
				<li>
					<input type="text" name="username" value="<?= $t["username"] ?>" />
					<input type="hidden" name="uid" value="<?= $t["uid"] ?>" />
				</li>

				<li><label><?= l('password'); ?></label></li>
				<li>
					<input type="text" name="password" value="<?= $t["password"] ?>" />
				</li>

				<li><label><?= l('role'); ?></label></li>
				<li>

					<?php
						if (isset($t['user_level'])) {
							echo '<select name="level">';

							foreach ($t['user_level'] as $key => $val) {
								$defname = ($key == $t["level"]) ? 'selected="selected"' : "";
								echo '<option '.$defname.' value="'. $key .'">'. $key .' -- '. $val .'</option>';
							}

							echo '</select>';
						}
					?>
					
				</li>

				
				<li>
					<br>
					<input type="submit" value="<?= l('submit'); ?>" class="" />
				</li>
			</ul>

		</form>
	</div>

<?php } ?>
