<?php

if (isset($GLOBALS['t']['admin_menu'])) {
	foreach ($GLOBALS['t']['admin_menu'] as $row) {

		echo '<div class="menu_item">';
		foreach ($row['head'] as $name => $link) {
			echo '<div class="head"><h4>'.l($name) .'</h4></div>';
		}

		echo '<div class="body"><ul>';
		foreach ($row['body'] as $name => $link) {
			echo '<li><a target="_self" href="'. $link .'" >'. l($name) .'</a></li>';
		}
		echo '</ul></div>';
		echo '</div>';

	}
}

?>

