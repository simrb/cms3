<?php access();

// commom
$t['uid'] 			= $uid	= user_id();
$t['ulevel'] 		= user_level();
$t["category_kv"] 	= header_menu();
$t["cid"]			= isset($_GET["cid"]) ? $_GET["cid"] : 0 ;
$t['web_title'] 	= $t["cid"] > 0 ? parse_text($t["category_kv"][$t["cid"]]['name']) .
						' - '. parse_text($t["category_kv"][$t["cid"]]['descript']) . ' - ' . parse_text(optionkv('web_header'))
						: parse_text(optionkv('web_title')) ;
$t["pagecurr"]		= 1;
$t["kw"]			= isset($_REQUEST["kw"]) ? $_REQUEST["kw"] : "";
$t["tag"]			= isset($_GET["tid"]) ? $_GET["tid"] : "";

$user_setting 		= array('nickname' => '', 'contact' => '', 'intro' => '');


// act: ajax_tagname
if ($t['_a'] == "ajax_tagname") {

	$reval = 0;
	$arr = array('info'=> array(), 'tid' => array(), 'error'=>0);
	//$arr = array('info'=> array('a', 'bb'), 'error'=>0 );

	if ($t["kw"] != '') {

		$kw = $t['kw'];
		//$kw = gbk_to_utf8($kw);
		$res = sql_query("SELECT tid, name FROM tag WHERE name LIKE '%$kw%'");
		$num = mysql_num_rows($res);
		if ($num > 0) {
			while ($row = mysql_fetch_assoc($res)) {
				array_push($arr['info'], $row['name']);
				$arr['tid'][$row['name']] = $row['tid'];
			}
		}

	}

	$arr['num'] = $num;
	exit(ajax_json($arr));
	//exit($arr);
}


// act: ajax_totop
if ($t['_a'] == "ajax_totop") {
	$reval = l('failure');
	if (isset($_GET['uid']) AND isset($_GET['rid'])) {
		if ($t['uid'] == $_GET['uid'] OR $t['ulevel'] > 4) {
			$t["msg"] = useract('totop', $_GET['uid'].date('d'));
			if ($t['msg'] == '' OR $t['ulevel'] > 4) {
				sql_query("UPDATE record SET created = '".time()."' WHERE rid = '".$_GET['rid']."' AND follow=0;");
				$reval = l('operated successfully');
			} else {
				$reval = l('you cannot fresh twice');
			}
		}
	}
	exit($reval);
}


// act: ajax_movepost
if ($t['_a'] == "ajax_movepost") {
	if ($t['ulevel'] > 4 AND isset($_GET['cid']) AND isset($_GET['rid'])) {
		sql_query("UPDATE record SET cid = '".$_GET['cid']."' WHERE rid = '".$_GET['rid']."';");
		exit(l('post has been moved'));
	} else {
		exit(l('failure'));
	}
}


// act: ajax_addpost
if ($t['_a'] == "ajax_addpost") {
	if ($t['ulevel'] > 4 AND isset($_GET['pre_txt']) AND isset($_GET['rid'])) {
		sql_query("UPDATE record SET content = '".$_GET['pre_txt']."' WHERE rid = '".$_GET['rid']."';");
		user_remind($_GET['pre_txt'], $_GET['rid']);
		exit(l('operated successfully'));
	} else {
		exit(l('failure'));
	}
}


// act: ajax_getpost
if ($t['_a'] == "ajax_getpost") {
	if (isset($_GET['rid'])) {
		$res = sql_query("SELECT content FROM record WHERE rid = '".$_GET['rid']."';");
		if ($row = mysql_fetch_row($res)) {
			exit(parse_text($row[0]));
		}
	}
	exit('');
}


// act: ajax_getuser
if ($t['_a'] == "ajax_getuser") {
	$reval = '';
	// return user nickname AND intro
	if (isset($_GET['uid']) AND $_GET['uid'] > 0) {
		$reval 		= userinfo($_GET['uid'], 'nickname');
		$intro 		= userinfo($_GET['uid'], 'intro');
// 		$res = sql_query("SELECT username FROM user WHERE uid = '".$_GET['uid']."';");
// 		if ($row = mysql_fetch_row($res)) {
// 			exit($row[0]);
// 		}
		if ($reval != '' AND $intro != '') {
			$reval .= ' - ';
		}
		$reval .= $intro;
		if (empty($reval)) {
			$reval = l('nothing');
		}
		exit(parse_text($reval));
	}

	exit(l('guest'));
}


// act: ajax_useful
if ($t['_a'] == "ajax_useful") {
	$reval = '0';
	if ($t['ulevel'] > 0 AND isset($_GET['rid']) ) {
		$res = useract('useful', $_GET['rid']);
		if (empty($res)) {
			$rec_field = record_get_field($_GET['rid']);
			$use_num = $rec_field['useful'];
			$use_uid = $rec_field['uid'];
			$use_num = $use_num != '' ? $use_num + 1 : 0;
			sql_query("UPDATE record SET useful = ".$use_num." WHERE rid = '".$_GET['rid']."';");
			$reval = "$use_num";

			// send msg to author
			usermsg($use_uid, $_GET['rid'], 2);
		}
	}
	exit($reval);
}


// act: settings
if ($t['_a'] == "settings") {

	// update password
	if (isset($_POST['password']) AND $_POST['password'] != '**') {
		sql_query("UPDATE user SET 
			password = '". $_POST["password"] ."' 
			WHERE uid = '".$uid."';"
		);
	}

	// update others
	foreach($user_setting as $key => $val) {
		if (isset($_POST[$key]) AND isset($_POST[$key."_old"]) 
		AND ($_POST[$key] != $_POST[$key."_old"])) {
			userinfo($uid, $key, $_POST[$key]);
		}
	}
	$t["msg"] = l('operated successfully');

}


// act: addcomment
if ($t['_a'] == "addcomment") {
	if (isset($_POST['rid']) AND isset($_POST['content'])) {
		$t['msg'] = '';

		$cdt = $t['ulevel'] > 0 ? 'i' : 'H'; 
		if (useract('addcmt', user_ip().date($cdt)) != '') {
			$t["msg"] = l('you cannot post twice');
		};

		$t['msg'] .= check_bad_word($_POST["content"]);

		if ($t["msg"] == '') {
			$insert_id = sql_query(
				"INSERT INTO record (
				uid, cid, follow, content, created
				) VALUES (
				'". $uid ."', '". $_POST["cid"] ."', '". $_POST["rid"] ."',
				'". $_POST["content"] ."', '". time() ."')", 'insert_id'
			);

			// remind user if the post content has memtioned him with a sign
			user_remind($_POST['content'], $insert_id);

			// comment number plus one
			recordlog($_POST['rid'], 'replies', 1, true);

			$t["msg"] = l('submitted successfully');
		}	
	}
}


// act: addpost
if ($t['_a'] == "addpost") {
	if (isset($_POST['cid']) AND isset($_POST['content'])) {
		$t['msg'] = '';

		// check the user level
		if ($t['ulevel'] < 1 ) {
			$t['msg'] = l('no level to post');
		}

		// check whether adding two posts in one minute
		if (useract('addpost', user_ip().date('i')) != '') {
			$t["msg"] .= l('you cannot post twice');
		}

		// check whether the bad words
		$t['msg'] .= check_bad_word($_POST["content"]);

		if ($t["msg"] == '') {
			// add record
			$insert_id = sql_query(
				"INSERT INTO record (
				uid, cid, follow, content, created
				) VALUES (
				'". $uid ."', '". $_POST["cid"] ."', 0,
				'". $_POST["content"] ."', '". time() ."')", 'insert_id'
			);

			user_remind($_POST['content'], $insert_id);

			$t["msg"] = l('submitted successfully');
		}
	}

	url_to( 'index.php?cid='. $_POST["cid"]);
}


// view: show
if ($t['_v'] == "show") {

	// pagination
	$t["url_after"] 	=	"";
	$pagecurr			=	(isset($_GET["pagecurr"]) AND $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagesize			=	$c['def_pagesize'] ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$filenums			=	0;

	$sql_str			= 	"SELECT * FROM record";

	// display record by tag searched
	if ($t['tag'] != '') {
		$sql_str .= " WHERE rid IN ( SELECT rid FROM tag_assoc WHERE tid = '". $t['tag'] ."')";
	
	// display record by text keyword
	} elseif($t['kw'] != '') {
		$sql_str .=	$t["cid"] > 0 ? " WHERE cid = " . $t["cid"] . " AND" : " WHERE";
		$sql_str .=	" content LIKE '%". $t["kw"] . "%'";

	// default
	} else {
		$sql_str .=	' WHERE follow = 0 AND cid = ';
		$sql_str .=	$t["cid"] > 0 ? $t["cid"] : "1";
	}


	$res 				= 	sql_query($sql_str);
	$filenums 			= 	mysql_num_rows($res);

	$pagenums		 	= 	ceil($filenums/$pagesize);
	$sql_str 			.=	" ORDER BY created DESC LIMIT $pagestart, $pagesize";

	$t["record_res"] 	= 	sql_query($sql_str);
	$t["pagecurr"]		=	$pagecurr;
	$t["pagenums"]		=	$pagenums;
	
	tpl($t, "flist");
}


// view: detail
if ($t['_v'] == "detail") {
	if (isset($_GET['rid'])) {

		$t["rid"]			= $_GET['rid'];
		$t['url']			= 'index.php?_v=detail&rid=' . $t['rid'] . '&_a=addcomment';

		$res = sql_query("SELECT content, cid, created, useful, uid FROM record 
							WHERE rid = ". $t["rid"] . " LIMIT 1");
		if ($res = mysql_fetch_row($res)) {

			// set head
			$t['web_title'] = parse_text(utf8_substr($res[0], 0, 30)) . ' - ' .  parse_text(optionkv('web_header'));
			$t['web_des'] 	= parse_text(utf8_substr($res[0], 0, 70));
			$t['cid'] 		= $res[1];

			// set body
			$t['record_res'] = array();
			$t['record_res']['content'] = $res[0];
			$t['record_res']['created'] = $res[2];
			$t['record_res']['useful'] 	= $res[3];
			$t['record_res']['uid'] 	= $res[4];

			// set comment
			$sql_str			= "SELECT rid, uid, content, useful, created FROM record 
									WHERE cid != 0 AND follow = ". $t["rid"] ." ORDER BY created";
			$t['record_cmt'] 	= sql_query($sql_str);
		}

		tpl($t, "fdetail");
	}
}


// view: search
if ($t['_v'] == "search") {
	$t["url_after"] 	=	"";
	$t['_a'] 			=	"";

	tpl($t, "fsearch", 'layout');
}


// view: addpost
if ($t['_v'] == "addpost") {
	$t["url_after"] 	=	"";
	$t['_a'] 			=	"addpost";
	$t['aboutpost'] 	= record_get_field($t['rid_aboutpost'], 'content');

	tpl($t, "faddpost");
}


// view: upload
if ($t['_v'] == "upload") {
	$t['_a'] 			=	"upload";

	tpl($t, "fupload");
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

	$res = sql_query("SELECT * FROM userinfo WHERE uid = ". $uid);

	if ($res) {
		while ($row = mysql_fetch_row($res)) {	
			foreach($user_setting as $key => $val) {
				if ($row[2] == $key) {
					$t[$key] = $row[3];
				}
			}
		}
	}

	tpl($t, "fsettings");
}


// view: message
if ($t['_v'] == "message") {
	user_is_login ();

	$t["msg_res"]		=	'';
	$t["url_after"] 	=	"";
	$t['_a'] 			=	"message";
	$t["cid"]			=	0 ;

	if ($t['user_msg_open'] == 'on') {
		// clear msg that has readed
		if (isset($_GET['usermsg'])) {
			userinfo($uid, 'new_msg', '0');
		}

		$t["msg_res"]	=	usermsg($uid);
	}

	tpl($t, "fmessage");
}


function header_menu() {
	$rows = array();
	if ($res = sql_query("SELECT * FROM category WHERE number > 0 ORDER BY number")) {
		while ($row = mysql_fetch_assoc($res)) {
			$rows[$row['cid']]  = $row;
		}
	}
	return $rows;
}


// set the link as static link
function front_link($type, $id, $pageid = 0) {
	$reval = '';

	// open seo
	if ($GLOBALS['c']['seo_open'] == 'off' OR (isset($GLOBALS['t']['kw']) AND $GLOBALS['t']['kw'] != '')) {
		if ($type == 'list') {
			$reval = "index.php?cid=$id&pagecurr=$pageid";
			if ($GLOBALS['t']['kw'] != "") {
				$reval .= "&kw=".$GLOBALS['t']['kw'];
			}
		} elseif ($type == 'detail') {
			$reval = "index.php?_v=detail&rid=$id";
		}

	// close seo
	} else {
		if ($type == 'list') {
			$reval = "cid-$id-$pageid.html";
		} elseif ($type == 'detail') {
			$reval = "detail-$id.html";
		}
	}

	return $reval;
}


function ajax_json ($data) {
	return json_encode($data);
// 	return json_encode(gbk_to_utf8($data));
}


function gbk_to_utf8($data) {
        if( is_array($data) ) {
            foreach ($data as $k => $v) {
                if ( is_array($v) ) {
                    $data[$k] = gbk_to_utf8($v);
                } else {
                    $data[$k] = iconv('gbk', 'utf-8', $v);
                }
            }
            return $data;
        } else {
            $data = iconv('gbk', 'utf-8', $data);
            return $data;
        }
}



?>
