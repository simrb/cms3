<?php access();


// act: edit
if ($t['_a'] == 'edit') {
	if (isset($_POST['web_logo']) 
	and isset($_POST['web_header'])
	and isset($_POST['web_title'])) {

		optionkv('web_logo',	$_POST['web_logo']);
		optionkv('web_header',	$_POST['web_header']);
		optionkv('web_title',	$_POST['web_title']);
		optionkv('web_des',		$_POST['web_des']);
		optionkv('web_style',	$_POST['web_style']);

		$t['msg'] = l('updated successfully');
	}
}


// view: info
if ($t['_v'] == "info") {
	$t['web_logo']		= optionkv('web_logo');
	$t['web_title']		= optionkv('web_title');
	$t['web_header']	= optionkv('web_header');
	$t['web_des']		= optionkv('web_des');
	$t['web_style']		= optionkv('web_style');

	tmp($t, $t['tpl_dir']."info");
}


// view: show
if ($t['_v'] == "show") {
	$t['welcome'] = l('welcome, dear ');
	tmp($t, $t['tpl_dir']."index");
}


?>
