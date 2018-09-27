<!doctype html>
<html lang="us">
<head>
	<?php include_once(tpl_path('head')); ?>
	<link href="<?= view_path('css/'.$t['web_style'].'.css') ?>" rel="stylesheet">
	<script src="<?= view_path('js/front.js') ?>"></script>
</head>

<body>
	<div class="ui-grid-layout" id="wrap" data-role="page" data-theme="z">
		<div class="ui-block-a"></div>
		<div class="ui-block-b">


			<div id="header">
				<a href="index.php"><h1><?= $t['web_header'] ?></h1></a>
			</div>

			<div id="bodyer">

				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(tpl_path($t['tpl_name'])); ?>
				
			</div>

			<div id="footer">
				<i>
					<?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['c']['version'] ?>
					<a href="index.php?_v=detail&rid=1" target="_blank"><?= l('about us'); ?></a>
				</i>
			</div>


		</div>
		<div class="ui-block-c"></div>
	</div>
</body>
</html>
