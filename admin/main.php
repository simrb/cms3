<?php access();

$t['tpl_name'] = 'amain';

// act: run
/*
	example 01, use it like the following
	$ php index.php _m=admin _f=main _a=task do=clear15
	$ php index.php _m=admin _f=main _a=task do=clear33

	example 02, or do all of default tasks
	$ php index.php _m=admin _f=main _a=task
*/
if ($t['_a'] == "task") {
	// do given task
	if (isset($_GET['do'])) {
		db_task($_GET['do']);
	
	// do default task
	} else {
		$cmds = array('clear10', 'clear13', 'clear15', 'clear33', 'clear41');
		foreach($cmds as $i => $cmd) {
			db_task($cmd);
		}
	}
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
	$t['web_logo']		= parse_text(optionkv('web_logo'));
	$t['web_header']	= parse_text(optionkv('web_header'));
	$t['web_title']		= parse_text(optionkv('web_title'));
	$t['web_des']		= parse_text(optionkv('web_des'));
	$t['web_style']		= parse_text(optionkv('web_style'));

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
