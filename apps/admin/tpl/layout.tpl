<!doctype html>
<html lang="us">
<head>
	<?php include_once(path_tmp('theme/head')); ?>
	<link href="<?= path_res('admin.css') ?>" rel="stylesheet">
	<script src="<?= path_res('admin.js') ?>"></script>
</head>

<body>
	<div id="wrap" data-role="page" data-theme="z">


		<div id="header">
			<a href="#"><h1><?= $t['web_name'] ?></h1></a>
		</div>


		<div id="bodyer"  class="ui-grid-layout" >
			<div id="lefter" class="ui-block-a">
				<div class="show-menu">
					<?php include_once(path_tmp('admin/tpl/menu')); ?>
				</div>
			</div>

			<div id="righter" class="ui-block-b">
				<p id="msg"><?= $t["msg"] ?></p>
				<?php include_once(path_tmp($tpl_name)); ?>
			</div>
		</div>


		<div id="footer">
			<?= $t['web_footer'].date('Y') ?> <?= $t['web_name'] ?> <?= $GLOBALS['cfg']['version'] ?> |
			<span><?= l('menber'); ?>: <?= user_name() ?> </span> |
			<span><a href="?" ><?= l('front end'); ?></a></span> |
			<span><a href="?_r=user&_a=logout" ><?= l('logout'); ?></a></span>
		</div>

	</div>

</body>
</html>
