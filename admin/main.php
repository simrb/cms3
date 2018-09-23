<?php access();

$t['tpl_name'] = 'amain';

// act: run
/*
	do it like cmd --->  $ php index.php _m=admin _f=main _a=run cdt=clear32
*/
if ($t['_a'] == "run") {
	$cdt 	= isset($_GET['cdt']) ? $_GET['cdt'] : '';
	$num	= db_optimize($cdt);
	exit;
// 	exit('back-end running, affect num : '. $num);
}


// act: clean_bak
if ($t['_a'] == "clean_bak") {
	
	foreach (glob("others/db.*") as $filename) {
		$filename = realpath($filename);
// 		unlink($filename);
		exec("rm ".$filename." -f");
	}

 	$t['msg'] = l('operated successfully');

}


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

	tpl($t, "ainfo");
}


// view: show
if ($t['_v'] == "show") {
	$t['welcome'] = l('welcome, dear ');
	tpl($t, "aindex");
}


// view: backup
if ($t['_v'] == "backup") {
	$t['bak_res'] = array();

	foreach (glob("./others/db.*") as $filename) {
		$t['bak_res'][] = $filename;
	}

	tpl($t, "abackup");
}


?>
