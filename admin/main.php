<?php access();

$t['tpl_name'] = 'amain';

// act: run
/*
	example 01, use it like the following
	$ php index.php _m=admin _f=main _a=task do=15
	$ php index.php _m=admin _f=main _a=task do=33

	example 02, or do all of default tasks
	$ php index.php _m=admin _f=main _a=task
*/
if ($t['_a'] == "task") {
	// do given task
	if (isset($_GET['do'])) {
		db_task($_GET['do']);
	
	// do default task
	} else {
		$cmds = array('10', '13', '15', '33', '41');
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


// act: addip
if ($t['_a'] == 'addip') {
	if (isset($_POST['ip_name']) and isset($_POST['ip_type']) and !empty($_POST['ip_name']) ) {
		sql_query("INSERT INTO userip (ip, ip_type) VALUES (
				'". parse_text($_POST['ip_name']) ."','". $_POST['ip_type'] ."')");
		$t['msg'] = l('added successfully');
	}

	if (isset($_POST['word_name']) AND !empty($_POST['word_name'])) {
		sql_query("INSERT INTO userword (word) VALUES ('". $_POST['word_name'] ."')");
		$t['msg'] = l('added successfully');
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


// view: defence
if ($t['_v'] == "defence") {
	$t['ip_num'] = $t['wd_num'] = 0;

	$res = sql_query('SELECT COUNT(uiid) AS ip_num FROM userip');
	if ($res) {
		$row = mysql_fetch_assoc($res);
		$t['ip_num'] = $row['ip_num'];
	}

	$res = sql_query('SELECT COUNT(uwid) AS wd_num FROM userword');
	if ($res) {
		$row = mysql_fetch_assoc($res);
		$t['wd_num'] = $row['wd_num'];
	}

	tpl($t, "adefence");
}



?>
