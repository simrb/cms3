<div class="top-bar right">
	<a href="?_v=detail&rid=1" ><?= l('about us'); ?></a>
	<a href="?_v=settings" ><?= l('menber'); ?></a>
</div>

<a href="?"><h1><?= $t['web_header'] ?></h1></a>

<div class="show-menu"> <?php if (isset($t["category_kv"])) {
		echo '<div class="menu_item" _v="'. $t['_v'] .'"><ul>';

	//	if ($t['_v'] == 'list' or $t['_v'] == 'show' or $t['_v'] == 'addpost' or $t['_v'] == 'detail') {
			foreach ($t["category_kv"] as $cid => $name) {
				$hl = ($cid == $t['cid']) ? 'menu_hl' : 'menu_no';
				echo '<li class="left '. $hl .'"><a href="?cid='. 
					$cid .'" >'. $name .'</a></li>';
			}
	//	} 

		if (user_level() > 1) {
			$hl = ('addpost' == $t['_v']) ? 'menu_hl' : '';
			echo '<li class="right '. $hl .'"><a href="?_v=addpost&cid='.
				$t['cid'] .'">'.l('add post').'</a></li>';
		}

		echo '</ul></div>';
} ?> </div>

