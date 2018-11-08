<div class="top-bar right">

	<?php 
		if (user_level() > 0) {
			// search link
			//echo '<a href="index.php?_v=search&cid='. $t['cid']. '" >'. l("search") . '</a>';

			// addpost link
			$hl = ('addpost' == $t['_v']) ? 'menu_hl' : '';
			echo '<a class=" '. $hl .' " href="index.php?_v=addpost&cid='.
				$t['cid'] .'">'.l('add post').'</a>';
		}
	?>

	<a href="index.php?_v=search&cid=<?=$t['cid']?>" ><?= l('search'); ?></a>
	<a href="index.php?_v=detail&rid=1" ><?= l('about us'); ?></a>

	<?php
		// message link
		if ($t['user_msg_open'] == 'on' AND $t['uid'] > 0 AND userinfo($t['uid'], 'new_msg') == 'has') {
				echo '<a href="index.php?_v=message&usermsg=has" >'. l('member') .'</a>';
				echo '<img src="'. $GLOBALS['c']['def_view'] .'/img/11.png">';

		// settings link
		} else {
			echo '<a href="index.php?_v=settings" >'. l('member') .'</a>';
		}
	?>

</div>

<div class='header_title' >
	<a href="index.php" ><h1><?= $t['web_header'] ?></h1></a>
</div>

<div class="show-menu">

	<?php if (isset($t["category_kv"])) {
			echo '<div class="menu_item" _v="'. $t['_v'] .'"><ul>';

	//	if ($t['_v'] == 'list' or $t['_v'] == 'show' or $t['_v'] == 'addpost' or $t['_v'] == 'detail') {
			echo '<li class="left hide"><a href="?cid=0" >'. l('trash') .'</a></li>';

			foreach ($t["category_kv"] as $cid => $row) {
				if ($cid == $t['cid']) {
					$hl = 'menu_hl';
					$pagenum = $t['pagecurr'];
				} else {
					$hl = 'menu_no';
					$pagenum = 1;
				}

				if ($row['number'] == 0) {
					$hl .= ' hide';
				}
				echo '<li class="left '. $hl .'"><a href="'. front_link('list', $cid, $pagenum)
					.'" title="' .  $row['descript']. '" cid='. $cid .' >'. $row['name'] .'</a></li>';
			}
	//	} 
		echo '</ul></div>';
	} ?>

</div>

