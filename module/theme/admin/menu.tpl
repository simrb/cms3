<?php

	// define the menu
	$layout = array(

		'admin_menu' 	=>	array(
			array(
				'head'	=>	array(l('records') =>	'img/6.png'),
				'body'	=>	array(
					l('record list')=>	'?_m=admin&_f=record',
					l('add')		=>	'?_m=admin&_f=record&_v=edit',
				),
			),
			array(
				'head'	=>	array(l('options') =>	'img/1.png'),
				'body'	=>	array(
					l('category')	=>	'?_m=admin&_f=category',
					l('file')		=>	'?_m=admin&_f=file',
					l('info')		=>	'?_m=admin&_f=main&_v=info',
				),
			),
			array(
				'head'	=>	array(l('users') =>	'img/8.png'),
				'body'	=>	array(
					l('user list')	=>	'?_m=admin&_f=user',
					l('status')		=>	'?_m=admin&_f=user&_v=status',
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

