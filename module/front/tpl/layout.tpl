<!doctype html>
<html lang="us">
<head>
	<?php include_once(path_tmp(THEME.'head')); ?>
	<link href="<?= path_theme('css/front.css') ?>" rel="stylesheet">
</head>

<body>
	<div class="ui-grid-layout" id="wrap" data-role="page" data-theme="z">
		<div class="ui-block-a"></div>
		<div class="ui-block-b">


			<div id="header">
				<?php include_once(path_tmp('front/tpl/header')); ?>
			</div>

			<div id="bodyer">
				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(path_tmp($tpl_name)); ?>
			</div>

			<div id="footer">
				<i>
					<?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['c']['version'] ?>
				</i>
			</div>


		</div>
		<div class="ui-block-c"></div>
	</div>
</body>
</html>
