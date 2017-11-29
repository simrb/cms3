<?php access();

// commom
$uid				= user_id();
$t["category_kv"] 	= data_fetch_kv("category", "cid", "name");
$t["cid"]			= isset($_GET["cid"]) ? $_GET["cid"] : 1 ;
$t['web_title'] 	= wption('web_title');


// act: settings
if ($t['_a'] == "settings") {

	// update password
	if (isset($_POST['password']) and $_POST['password'] != '**') {
		sql_query("UPDATE user SET 
			password = '". $_POST["password"] ."' 
			WHERE uid = '".$uid."';"
		);
	}

	// change nickname
	if (isset($_POST['nickname1']) and isset($_POST['nickname1']) 
	and ($_POST['nickname1'] != $_POST['nickname2'])) {
		// insert
		$res = sql_query("SELECT wval FROM wption WHERE uid = ". $uid ." AND wkey = 'nickname';");
		if (mysql_num_rows($res) == 0) {
			sql_query("INSERT INTO wption (uid, wkey, wval) VALUES (
				'". $uid ."', 'nickname', '". $_POST["nickname1"] ."'
			);");

		// update
		} else {
			sql_query("UPDATE wption SET 
				wval = '". $_POST["nickname1"] ."' 
				WHERE uid = '".$uid."' AND wkey = 'nickname';"
			);
		}
	}

	// change contact
	if (isset($_POST['contact1']) and isset($_POST['contact1']) 
	and ($_POST['contact1'] != $_POST['contact2'])) {
		// insert
		$res = sql_query("SELECT wval FROM wption WHERE uid = ". $uid ." AND wkey = 'contact';");
		if (mysql_num_rows($res) == 0) {
			sql_query("INSERT INTO wption (uid, wkey, wval) VALUES (
				'". $uid ."', 'contact', '". $_POST["contact1"] ."'
			);");

		// update
		} else {
			sql_query("UPDATE wption SET 
				wval = '". $_POST["contact1"] ."' 
				WHERE uid = '".$uid."' AND wkey = 'contact';"
			);
		}
	}

	// change introduction
	if (isset($_POST['intro1']) and isset($_POST['intro1']) 
	and ($_POST['intro1'] != $_POST['intro2'])) {
		// insert
		$res = sql_query("SELECT wval FROM wption WHERE uid = ". $uid ." AND wkey = 'intro';");
		if (mysql_num_rows($res) == 0) {
			sql_query("INSERT INTO wption (uid, wkey, wval) VALUES (
				'". $uid ."', 'intro', '". $_POST["intro1"] ."'
			);");

		// update
		} else {
			sql_query("UPDATE wption SET 
				wval = '". $_POST["intro1"] ."' 
				WHERE uid = '".$uid."' AND wkey = 'intro';"
			);
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
				'". $_POST["content"] ."', '". date("Y-m-d H:i:s") ."')"
			);
			$t["msg"] = l('submitted successfully');
		}

	}
}


// act: addpost
if ($t['_a'] == "addpost") {
	if (isset($_POST['cid']) and isset($_POST['content'])) {
		
 		$t["msg"] = user_allow_submit();
		$t['msg'] = '';

		if ($t["msg"] == '') {

			// add record
			$insert_id = sql_query(
				"INSERT INTO record (
				uid, cid, follow, content, created
				) VALUES (
				'". $uid ."', '". $_POST["cid"] ."', 0,
				'". $_POST["content"] ."', '". date("Y-m-d H:i:s") ."')", 'insert_id'
			);
			$t["msg"] = l('submitted successfully');

			// add upload
			$t['_a'] = 'add';
			$t['_v'] = '';
			require_once(PATH_MOD.'admin/file.php');

			// add upload log for record
			$rid	= $insert_id;
			sql_query("INSERT INTO wption (uid, wkey, wval) VALUES ('". $uid .
				"', 'img_r" . $rid . "', '". $path ."');");

		}

	}

	url_to( '?cid='. $_POST["cid"]);
}


// view: show
if ($t['_v'] == "show") {

	// pagination
	$t["url_after"] 	=	"";
	$pagecurr			=	(isset($_GET["pagecurr"]) and $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagesize			=	9 ;
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
	
	tmp($t, "front/tpl/list");
}


// view: detail
if ($t['_v'] == "detail") {
	if (isset($_GET['rid'])) {

		$t["rid"]			= $_GET['rid'];
		$t['url']			= '?_v=detail&rid=' . $t['rid'] . '&_a=addcomment';

		$res = sql_query("SELECT content, cid, created, useful FROM record 
							WHERE rid = ". $t["rid"] . " LIMIT 1");
		if ($res = mysql_fetch_row($res)) {
			// set head
			$t['web_title'] = utf8_substr($res[0], 0, 30) . ' -- ' . wption('web_header');
			$t['web_des'] 	= utf8_substr($res[0], 0, 70);
			$t['cid'] 		= $res[1];

			// set body
			$t['record_res'] = array();
			$t['record_res']['content'] = $res[0];
			$t['record_res']['created'] = $res[2];
			$t['record_res']['useful'] 	= $res[3];

			// set comment
			$sql_str			= "SELECT rid, uid, content, useful, created FROM record 
									WHERE follow = ". $t["rid"];
			$t['record_cmt'] 	= sql_query($sql_str);

			// set picture
			$res = sql_query("SELECT wval FROM wption WHERE wkey = 'img_r". $t["rid"] 
					. "' LIMIT 1");
			if ($res = mysql_fetch_row($res)) {
				if (!empty($res[0])) {
					$t['record_img'] = $res[0];
				}
			}
		}

		tmp($t, "front/tpl/detail");
	}
}


// view: addpost
if ($t['_v'] == "addpost") {
	$t["url_after"] 	=	"";
	$t['_a'] 			=	"addpost";
	tmp($t, "front/tpl/addpost");
}


// view: settings
if ($t['_v'] == "settings") {
	user_is_login ();

	$t["url_after"] 	=	"";
	$t['_a'] 			=	"settings";
	$t["cid"]			=	0 ;

	$t['nickname1'] 	= $t['contact1'] = $t['intro1'] = '';

	$res = sql_query("SELECT * FROM wption WHERE uid = ". $uid);

	if ($res) {
		while ($row = mysql_fetch_row($res)) {	
			if ($row[2] == 'nickname') {
				$t['nickname1'] = $row[3];
			} elseif ($row[2] == 'contact') {
				$t['contact1'] = $row[3];
			} elseif ($row[2] == 'intro') {
				$t['intro1'] = $row[3];
			}
		}
	}

	tmp($t, "front/tpl/settings");
}


?>
