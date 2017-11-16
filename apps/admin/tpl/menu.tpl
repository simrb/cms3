<?php

	// define the menu
	$layout = array(

		'admin_menu' 	=>	array(
			array(
				'head'	=>	array(l('records') =>	'img/6.png'),
				'body'	=>	array(
					l('record list')=>	'?_r=record',
					l('add')		=>	'?_r=record&_v=edit',
				),
			),
			array(
				'head'	=>	array(l('options') =>	'img/1.png'),
				'body'	=>	array(
					l('category')	=>	'?_r=category',
					l('file')		=>	'?_r=file',
					l('info')		=>	'?_r=admin&_v=info',
				),
			),
			array(
				'head'	=>	array(l('users') =>	'img/8.png'),
				'body'	=>	array(
					l('user list')		=>	'?_r=user',
					l('status')		=>	'?_r=user&_v=status',
				//	l('front end')	=>	'?',
				//	l('quit')		=>	'?_r=user&_a=logout',
				),
			),
		),

	);

	// parse the menu 
	if (isset($layout['admin_menu'])) {
		foreach ($layout['admin_menu'] as $row) {

			echo '<div class="menu_item">';
			foreach ($row['head'] as $name => $link) {
				echo '<div class="head"><h4>'. $name .'</h4></div>';
			}
			
			echo '<div class="body"><ul>';
			foreach ($row['body'] as $name => $link) {
				echo '<li><a target="_self" href="'. $link .'" >'. $name .'</a></li>';
			}
			echo '</ul></div>';
			echo '</div>';

		}
	}

	
?>



<!--
<?php
	if (isset($layout['admin_menu'])) {
		foreach ($layout['admin_menu'] as $row) {

				echo '<div class="menu_item">';
				foreach ($row['head'] as $name => $link) {
					echo '<div class="head"><img src="'. path_res($link) .'" /><h4>'. $name .'</h4></div>';
				}
				
				echo '<div class="body"><ul>';
				foreach ($row['body'] as $name => $link) {
					echo '<li><a href="'. $link .'" >'. $name .'</a></li>';
				}
				echo '</ul></div></div>';

			}
	
	}
?>
-->


