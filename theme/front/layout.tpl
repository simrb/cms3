<!doctype html>
<html lang="us">
<head>
	<?php include_once(path_tmp(THEME.'head')); ?>
	<link href="<?= path_theme('css/front.css') ?>" rel="stylesheet">
	<script src="<?= path_theme('js/front.js') ?>"></script>
</head>

<body>
	<div class="ui-grid-layout" id="wrap" data-role="page" data-theme="z">
		<div class="ui-block-a"></div>
		<div class="ui-block-b">


			<div id="header">
				<?php include_once(path_tmp(THEME.'front/header')); ?>
			</div>

			<div id="bodyer">
				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(path_tmp($t['tpl_name'])); ?>
			</div>

			<div id="footer">
				<i>
					<?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['c']['version'] ?>
				</i>

				<div class="right" >
				<?php if (user_level() > 5) { ?>
					<i >
						<a href="?_m=admin" target="_blank"><?= l('back end') ?></a>	
					</i>

					<span> | </span>
				<?php } ?>


				<?php if (user_level() > 0) { ?>
					<i >
						<a href="?_v=upload" target="_blank"><?= l('upload file') ?></a>	
					</i>

				<span> | </span>

					<i >
						<a href="<?=$t['link_logout'];?>" ><?= l('logout'); ?></a>
					</i>
				<?php } ?>
				</div>
	
			</div>


		</div>
		<div class="ui-block-c"></div>
	</div>
</body>
</html>
