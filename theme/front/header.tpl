<div class="top-bar right">
	<?php if (user_level() > 0) {
			echo '<a href="?_v=upload" target="_blank">'. l('upload') .'</a>';
			$hl = ('addpost' == $t['_v']) ? 'menu_hl' : '';
			echo '<a class=" '. $hl .' addpost" href="?_v=addpost&cid='.
				$t['cid'] .'">'.l('add post').'</a>';
	} ?>
	<a href="?_v=detail&rid=1" ><?= l('about us'); ?></a>
	<a href="?_v=settings" ><?= l('menber'); ?></a>
</div>

<div class='header_title' >
	<a href="?" ><h1><?= $t['web_header'] ?></h1></a>
</div>


<div class="show-menu"> <?php if (isset($t["category_kv"])) {
		echo '<div class="menu_item" _v="'. $t['_v'] .'"><ul>';

	//	if ($t['_v'] == 'list' or $t['_v'] == 'show' or $t['_v'] == 'addpost' or $t['_v'] == 'detail') {
			foreach ($t["category_kv"] as $cid => $row) {
				$hl = ($cid == $t['cid']) ? 'menu_hl' : 'menu_no';
				echo '<li class="left '. $hl .'"><a href="?cid='. 
					$cid .'" title="' .  $row['descript']. '" >'. $row['name'] .'</a></li>';
			}
	//	} 


		echo '</ul></div>';
} ?> </div>

