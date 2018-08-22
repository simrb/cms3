<?php access();

// commom
$uid				= user_id();
$t["category_kv"] 	= data_fetch_category("category", "cid", "name");
$t["cid"]			= isset($_GET["cid"]) ? $_GET["cid"] : 1 ;
$t['web_title'] 	= optionkv('web_title');

$user_setting 		= array('nickname' => '', 'contact' => '', 'intro' => '');

// act: ajax_movepost
if ($t['_a'] == "ajax_movepost") {
	if (user_level() > 4 and isset($_GET['cid']) and isset($_GET['rid'])) {
		sql_query("UPDATE record SET cid = '".$_GET['cid']."' WHERE rid = '".$_GET['rid']."';");
		exit(l('operated successfully'));
	} else {
		exit(l('failure'));
	}
}


// act: ajax_addpost
if ($t['_a'] == "ajax_addpost") {
	if (user_level() > 4 and isset($_GET['pre_txt']) and isset($_GET['rid'])) {
		sql_query("UPDATE record SET content = '".$_GET['pre_txt']."' WHERE rid = '".$_GET['rid']."';");
		//exit('success -- '. $_GET['rid'] . ' '. $_GET['pre_txt']);
		exit(l('operated successfully'));
	} else {
		exit(l('failure'));
	}
}


// act: ajax_getpost
if ($t['_a'] == "ajax_getpost") {
	if (user_level() > 4 and isset($_GET['rid'])) {
		$res = sql_query("SELECT content FROM record WHERE rid = '".$_GET['rid']."';");
		if ($row = mysql_fetch_row($res)) {
			exit($row[0]);
		}
	}
	exit(l('failure'));
}


// act: ajax_useful
if ($t['_a'] == "ajax_useful") {
	if (user_level() > 4 and isset($_GET['rid']) and isset($_GET['useful_val'])) {
		sql_query("UPDATE record SET useful = ".$_GET['useful_val']." WHERE rid = '".$_GET['rid']."';");
		exit(l('operated successfully'));
	}
	exit(l('failure'));
}


// act: useful
if ($t['_a'] == "useful") {
	if (user_level() > 4 and isset($_GET['rid'])) {
		if (isset($_GET['cmt'])) {
			sql_query("UPDATE record SET useful = 1 WHERE rid = '".$_GET['cmt']."';");
		} else {
			sql_query("UPDATE record SET useful = 1 WHERE rid = '".$_GET['rid']."';");
		}
	}
	$t['_v'] = 'detail';
}


// act: delpost
// just modify the category id as 0, don`t delete it really
if ($t['_a'] == "delpost") {
	if (user_level() > 4 and isset($_GET['rid'])) {
		if (isset($_GET['cmt'])) {
			sql_query("UPDATE record SET cid = 0 WHERE rid = '".$_GET['cmt']."';");
			$t['_v'] = 'detail';
		} else {
			sql_query("UPDATE record SET cid = 0 WHERE rid = '".$_GET['rid']."';");
			$t['_v'] = 'show';
			$t['msg'] = l('deleted successfully');
			// $t['cid'] = ;
		}
	}
}


// act: settings
if ($t['_a'] == "settings") {

	// update password
	if (isset($_POST['password']) and $_POST['password'] != '**') {
		sql_query("UPDATE user SET 
			password = '". $_POST["password"] ."' 
			WHERE uid = '".$uid."';"
		);
	}

	foreach($user_setting as $key => $val) {
		if (isset($_POST[$key]) and isset($_POST[$key."_old"]) 
		and ($_POST[$key] != $_POST[$key."_old"])) {
			userkv($uid, $key, $_POST[$key]);
		}
	}

}


// act: add
if ($t['_a'] == "addcomment") {
	if (isset($_POST['rid']) and isset($_POST['content'])) {
		
		$t["msg"] = user_allow_submit();
		if ($t["msg"] == '') {
			sql_query(
				"INSERT INTO record (
				uid, cid, follow, content, created
				) VALUES (
				'". $uid ."', '". $_POST["cid"] ."', '". $_POST["rid"] ."',
				'". $_POST["content"] ."', '". time() ."')"
			);
			$t["msg"] = l('submitted successfully');
		}

	}
}


// act: addpost
if ($t['_a'] == "addpost") {
	if (isset($_POST['cid']) and isset($_POST['content'])) {

		$t['msg'] = '';
 		$t["msg"] = user_allow_submit();

		if (user_level() < 1 ) {
			$t['msg'] = l('no level to post');
		}

		if ($t["msg"] == '') {
			// add record
			$insert_id = sql_query(
				"INSERT INTO record (
				uid, cid, follow, content, created
				) VALUES (
				'". $uid ."', '". $_POST["cid"] ."', 0,
				'". $_POST["content"] ."', '". time() ."')", 'insert_id'
			);
			$t["msg"] = l('submitted successfully');
		}

	}

	url_to( '?cid='. $_POST["cid"]);
}


// view: show
if ($t['_v'] == "show") {

	// pagination
	$t["url_after"] 	=	"";
	$pagecurr			=	(isset($_GET["pagecurr"]) and $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagesize			=	$c['def_pagesize'] ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$filenums			=	0;

	$sql_str			= 	"SELECT * FROM record WHERE cid != 0 AND follow = 0";
	$sql_str			.=	$t["cid"] > 0 ? (" and cid = ". $t["cid"]) : "";
	$res 				= 	sql_query($sql_str);
	$filenums 			= 	mysql_num_rows($res);

	$pagenums		 	= 	ceil($filenums/$pagesize);
	$sql_str 			.=	" ORDER BY rid DESC LIMIT $pagestart, $pagesize";

	$t["record_res"] 	= 	sql_query($sql_str);
	$t["pagecurr"]		=	$pagecurr;
	$t["pagenums"]		=	$pagenums;
	
	tmp($t, $t['tpl_dir']."list");
}


// view: detail
if ($t['_v'] == "detail") {
	if (isset($_GET['rid'])) {

		$t["rid"]			= $_GET['rid'];
		$t['url']			= '?_v=detail&rid=' . $t['rid'] . '&_a=addcomment';

		$res = sql_query("SELECT content, cid, created, useful, uid FROM record 
							WHERE rid = ". $t["rid"] . " LIMIT 1");
		if ($res = mysql_fetch_row($res)) {

			// set head
			$t['web_title'] = utf8_substr($res[0], 0, 30) . ' -- ' . optionkv('web_header');
			$t['web_des'] 	= utf8_substr($res[0], 0, 70);
			$t['cid'] 		= $res[1];

			// set body
			$t['record_res'] = array();
			$t['record_res']['content'] = $res[0];
			$t['record_res']['created'] = $res[2];
			$t['record_res']['useful'] 	= $res[3];
			$t['record_res']['uid'] 	= $res[4];

			// set comment
			$sql_str			= "SELECT rid, uid, content, useful, created FROM record 
									WHERE cid != 0 AND follow = ". $t["rid"];
			$t['record_cmt'] 	= sql_query($sql_str);
		}

		tmp($t, $t['tpl_dir']."detail");
	}
}


// view: addpost
if ($t['_v'] == "addpost") {
	$t["url_after"] 	=	"";
	$t['_a'] 			=	"addpost";
	$t['aboutpost'] 	= record_get_content($t['rid_aboutpost']);

	tmp($t, $t['tpl_dir']."addpost");
}


// view: upload
if ($t['_v'] == "upload") {
	$t['_a'] 			=	"upload";

	tmp($t, $t['tpl_dir']."upload");
}


// view: settings
if ($t['_v'] == "settings") {
	user_is_login ();

	$t["url_after"] 	=	"";
	$t['_a'] 			=	"settings";
	$t["cid"]			=	0 ;

// 	$t['nickname'] 	= $t['contact'] = $t['intro'] = '';
	foreach($user_setting as $key => $val) {
		$t[$key] = '';
	}

	$res = sql_query("SELECT * FROM userkv WHERE uid = ". $uid);

	if ($res) {
		while ($row = mysql_fetch_row($res)) {	
			foreach($user_setting as $key => $val) {
				if ($row[2] == $key) {
					$t[$key] = $row[3];
				}
			}
		}
	}

	tmp($t, $t['tpl_dir']."settings");
}


function data_fetch_category($tablename, $key, $val) {
	$rows = array();
	if ($res = sql_query("SELECT * FROM ". $tablename . " WHERE number > 0 ORDER BY number")) {
		while ($row = mysql_fetch_assoc($res)) {
			$rows[$row[$key]]  = $row;
		}
	}
	return $rows;
}



?>
