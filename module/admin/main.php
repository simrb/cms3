<?php access();
$t['layout'] 	= 'admin/tpl/layout';

// act: edit
if ($t['_a'] == 'edit') {
	if (isset($_POST['web_logo']) 
	and isset($_POST['web_header'])
	and isset($_POST['web_title'])) {

		wption_set('web_logo', $_POST['web_logo']);
		wption_set('web_header', $_POST['web_header']);
		wption_set('web_title', $_POST['web_title']);
		wption_set('web_des', $_POST['web_des']);

		$t['msg'] = l('updated successfully');
	}
}


// view: show
if ($t['_v'] == "show") {
	$t['welcome'] = l('welcome, dear ');
	tmp($t, "admin/tpl/index");
}


// view: info
if ($t['_v'] == "info") {
	$t['web_logo']		= wption('web_logo');
	$t['web_title']		= wption('web_title');
	$t['web_header']	= wption('web_header');
	$t['web_des']		= wption('web_des');

	tmp($t, "admin/tpl/info");
}

?>
