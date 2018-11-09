<form action="<?=$t['_a']?>" method="get" class="search_menu" target="_blank">

	<?php if (isset($t["category_kv"])) {
			echo '<p><select class="search_select" name="cid">';

			echo '<option value=1 > --'. l('category') .'-- </option>';

			foreach ($t["category_kv"] as $cid => $row) {
				echo '<option value="'. $cid .'">'. $row['name'] .'</option>';
			}


			echo '</select></p>';
	} ?>

	<p><input type="text" value="" name="kw" /></p>
	<p><input type="submit" value="<?= l('search'); ?>" /></p>
</form>

