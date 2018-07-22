<!doctype html>
<html lang="us">
<head>
	<?php include_once(path_tmp(THEME.'head')); ?>
	<link href="<?= path_theme('css/admin.css') ?>" rel="stylesheet">
	<script src="<?= path_theme('js/admin.js') ?>"></script>
</head>

<body>
	<div id="wrap" data-role="page" data-theme="z">


		<div id="header">
			<a href="#"><h1><?= l('background management'); ?></h1></a>
		</div>


		<div id="bodyer"  class="ui-grid-layout" >
			<div id="lefter" class="ui-block-a">
				<div class="show-menu">
					<?php include_once(path_tmp(THEME.'admin/menu')); ?>
				</div>
			</div>

			<div id="righter" class="ui-block-b">
				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(path_tmp($t['tpl_name'])); ?>
			</div>
		</div>


		<div id="footer">
			<?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['c']['version'] ?> |
			<span><?= l('menber'); ?>: <?= user_name() ?> </span> |
			<span><a href="?_m=admin" ><?= l('back end'); ?></a></span> |
			<span><a href="?" target="_blank" ><?= l('front end'); ?></a></span> |
			<span><a href="<?=$t['link_logout'];?>" ><?= l('logout'); ?></a></span>
		</div>

	</div>

</body>
</html>
