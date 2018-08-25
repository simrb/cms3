<!doctype html>
<html lang="us">
<head>
	<?php include_once(tpl_path(VIEW_DIR.'head')); ?>
	<link href="<?= view_path('css/front.css') ?>" rel="stylesheet">
	<script src="<?= view_path('js/front.js') ?>"></script>
</head>

<body>
	<div class="ui-grid-layout" id="wrap" data-role="page" data-theme="z">
		<div class="ui-block-a"></div>
		<div class="ui-block-b">

			<div id="header">
				<?php include_once(tpl_path(VIEW_DIR.'front/header')); ?>
			</div>

			<div id="bodyer">
				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(tpl_path($t['tpl_name'])); ?>
			</div>

			<div id="footer">
				<i><?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['c']['version'] ?></i>

				<div class="right" >
					<?php if (user_level() > 5) { ?>
						<a href="?_m=admin" target="_blank"><?= l('back end') ?></a>	

						
					<?php }  if (user_level() > 0) { ?>
						<a href="<?=$t['link_logout'];?>" ><?= l('logout'); ?></a>
					<?php } ?>
				</div>
			</div>

		</div>
		<div class="ui-block-c"></div>
	</div>
</body>
</html>