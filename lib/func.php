<?php access();

$filter_str = array(
	'='			=> 'rp01',
	'%'			=> 'rp02',
	';'			=> 'rp03',
	'"'			=> 'rp04',
	"'"			=> 'rp05',
	"("			=> 'rp06',
	")"			=> 'rp07',
	"*"			=> 'rp08',
	">"			=> 'rp09',
	"<"			=> 'rp10',
	"{"			=> 'rp11',
	"}"			=> 'rp12',
	"\\"		=> 'rp13',
	'/'			=> 'rp14',
	'.'			=> 'rp15',
	','			=> 'rp16',
// 	'_'			=> 'rp17',
	'$'			=> 'rp18',
	'!'			=> 'rp19',
	'?'			=> 'rp20',
	'-'			=> 'rp21',
);

// return the dir path, if it is`t existed, just creates it
function path_dir ($path) {
	$path = MODULE_PATH.$path.'/';
	mk_dir($path);
	return $path;
}


function mk_dir($dir, $mode = 0777) {
	if (is_dir($dir) || @mkdir($dir,$mode)) return true;
	if (!mk_dir(dirname($dir),$mode)) return false;
	return @mkdir($dir,$mode);
} 


// return the real path for static resource file, like js, css
function view_path ($path) {
	$path = VIEW_DIR . $path;
	if (!file_exists($path)) {
		$path = "no file $path";
	}
	return $path;
}


/* 	return absolute path
	
	for example
	tpl_path('view/front/mytpl');		#=> /var/www/html/demo/view/front/mytpl.tpl

*/

function tpl_path ($path) {
	return MODULE_PATH.VIEW_DIR.$path.'.tpl';
}


/*	load the template

	for example, specified tpl_name and default layout
	tpl($t, 'mytpl');

	for example, specified tpl_name and specified layout
	tpl($t, 'mytpl', 'mylayout');

	for example, no layout
	tpl($t, 'mytpl', 'unlayout');

*/
function tpl($t, $tpl_name = '', $layout = '') {
	$t['web_logo']		=	optionkv('web_logo');
	$t['web_header']	=	optionkv('web_header');
	$t["msg"]			=	isset($t["msg"]) ? date("Y-m-d H:i:s")." ".$t["msg"] : "";
	$t["tpl_name"]		=	$tpl_name != '' ? $tpl_name : $t["tpl_name"];
	$t["tpl_layout"]	=	$layout != '' ? $layout : $t["tpl_layout"];

	if ($layout == 'unlayout') {
		include_once(tpl_path($t['tpl_name']));
	} else {
		include_once(tpl_path($t["tpl_layout"]));
	}
}

/*	show error page, and exit current proccessing

	for example,
	out('occured an error', $t);

	for example, with specified layout
	out('occured an error', $t, 'layout');
*/
function out($str, $t, $layout = 'layout') {
	$t["msg"] = $str;
	//$t["blank"] = $str;
	tpl($t, 'blank', $layout);
	exit;
}


/*	change the language from en to what you want

	for example,
	l('myname');		#=>	'myname'
*/
function l ($str) {
	$reval 	= $str;
	$path 	= VIEW_DIR . 'lang/' . $GLOBALS['c']['def_lang'] . '.php';
	if (file_exists($path)) {
		require $path;
		if (isset($lang[$str])) {
			if ( $lang[$str] != '' ) {
				$reval = $lang[$str];
			}
		}
	}
	return $reval;
}


// change the link pattern
function url ($arr) {
	$str = '?';
	foreach (array('_m', '_f', '_a', '_v') as $val) {
		if (!isset($arr[$val])) { $arr[$val] = $GLOBALS["t"][$val]; }
	}
	foreach ($arr as $key => $val) {
		$str .= '&'. $key. '='. $val;
	}
	return $str;
}


/*	complete the url with _m, _f

	for example, when your default module is front and file is main.php
	url_c('_x=sss');		#=>	'?_m=front&_f=main&_x=sss&'
	url_c('_x=sss&_v=vv');	#=>	'?_m=front&_f=main&_x=sss&_v=vv&'

*/
function url_c ($str = '') {
	$url = isset($GLOBALS["t"]['url']) ? $GLOBALS["t"]['url'] : '';
	$str = '?_m='. $GLOBALS["t"]['_m']. '&_f='. $GLOBALS["t"]['_f'] . '&' . $str . '&' . $url ;
	return $str;
}


// jump to certain page
function url_to ($url = "index.php") {
	Header("HTTP/1.1 303 See Other");
	Header("Location: $url");
	exit;
}


// set or get the http_referer value
// set it by an argv , get it with no argv given.
function url_referer ($url = '') {
	// save 
	if ( $url != '') {
		$url_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $url ;
		setcookie("http_referer", $url_referer, time()+60*5);

	} else {
		return (isset($_COOKIE["http_referer"]) ? $_COOKIE["http_referer"] : '/');
	}
}


/*	return a key-val result that getting from database by a table and two fields given
	
	for example,
	data_fetch_kv('user', 'username', 'password');	#=> array('linyu' => '8888', 'viewer' => '8888')

*/
function data_fetch_kv($tablename, $key, $val) {
	$rows = array();
	if ($res = sql_query("SELECT * FROM ". $tablename)) {
		while ($row = mysql_fetch_assoc($res)) {
			$rows[$row[$key]]  = $row[$val];
		}
	}
	return $rows;
}


// fetch a data collection from db
function sql_query($sql, $op = NULL) {

	$conn = mysql_connect($GLOBALS['c']['sql_server'], $GLOBALS['c']['sql_user'], $GLOBALS['c']['sql_pawd']);
	if (!$conn) {
		$error = $GLOBALS['c']['def_mode'] == 'test' ? "Could not connect: " . mysql_error() : '';
		die($error);
	}

	$res = mysql_select_db($GLOBALS['c']['sql_dbname'], $conn);
	if (!$res) {
		$error = $GLOBALS['c']['def_mode'] == 'test' ? "Can't use db ". $GLOBALS['c']['sql_dbname'] . mysql_error() : '';
		die($error);
	}

	$result = mysql_query($sql);
	if (!$result) {
		$error = $GLOBALS['c']['def_mode'] == 'test' ? "Could not query: " . mysql_error() : '';
		die($error);
	}

	if ($op == 'insert_id') {
		$result = mysql_insert_id();
	} elseif ($op == 'affect_num') {
		$result = mysql_affected_rows();
	}

	mysql_close($conn);

	return $result;
}

function sql_filter($arr) {
    if (is_array($arr)) {
        foreach($arr as $k => $v) {
            $arr[$k] = sql_filter($v);
        }
    } else {
        $arr = sql_filter_str($arr);
    }
    return $arr;
}

function sql_filter_str($str) {
// 	$str = mysql_real_escape_string($str);

	if (!get_magic_quotes_gpc()) {
// 		$str = addslashes($str);
	}

	foreach($GLOBALS['filter_str'] as $key => $val) {
		$str = str_replace($key, $val, $str);
	}

    return trim($str);
}

// parse encode text to normal text
function parse_text($str) {

	if (!get_magic_quotes_gpc()) {
// 		$text = stripslashes($text);
	}

// 	$str = strip_tags($str);

	foreach($GLOBALS['filter_str'] as $key => $val) {
		$str = str_replace($val, $key, $str);
	}

	return $str;
}

// parse text to html
function parse_html($str) {
//   	$str = htmlspecialchars_decode($str);
//  	$str = htmlentities($str);
//   	$str = html_entity_decode($str);
// 	$str = str_replace('<', '&lt;', $str);
//  $str = str_replace('>', '&gt;', $str);
// 	$str = str_replace(array("&gt;", "&lt;", "&quot;", "&amp;"), array(">", "<", "\"", "&"), $str);
    $str =  htmlspecialchars(parse_text($str));
	return $str;
}



// cut string with utf8
function utf8_substr($str, $from, $len) {
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
	'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', '$1' , $str);

	
/*	$tmpstr = "";
    $strlen = $from + $len;
    for($i = 0; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else
            $tmpstr .= substr($str, $i, 1);
    }
    return $tmpstr;*/
}

function utf8_substr2($str, $from, $len) {
	$tmpstr = "";
    $strlen = $from + $len;
    for($i = 0; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else
            $tmpstr .= substr($str, $i, 1);
    }
    return $tmpstr;
}

/*function is_gbk($str) {
	return preg_match("/[\x7f-\xff]/", $str) ? true : false;
}
*/

/**************** user func libs ******************/
// user login, success return true.
function user_login ($name, $pawd) {
	$reval 		= false;
	$res 		= sql_query("SELECT * FROM user WHERE 
					username = '". $name ."' AND password ='". user_encode_pwd($pawd) ."' ;");

	if (mysql_num_rows($res) > 0) {
		$row 	= mysql_fetch_row($res);
		$token	= md5($row[0] + date('YmdHis'));
		$time	= time()+3600*24*7;

		// set the user info for login, expire time in 7 days
		setcookie("token", $token, $time);

		// save a token
		sql_query("INSERT INTO usersess (uid, token, created, exptime) VALUES (
			'".$row[0]."', '$token', '".time()."', '".$time."')");

		$reval 	= true;
	}

	return $reval;
}

function user_logout () {
	$token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : '';
	setcookie("token", time()-1);

	// remove from db
	if(!empty($token)) {
		sql_query("DELETE FROM usersess WHERE token = '$token'");
	}
}


function user_encode_pwd ($pawd) {
	return md5($pawd. $GLOBALS["c"]['sn']);
}

// return the user id current he logined
function user_id () {
	$info = userbase();
	return (isset($info[0]) ? $info[0] : 0);
}

// return the user name 
function user_name () {
	$info = userbase();
	return (isset($info[1]) ? $info[1] : 'default');
}

// return the user level
function user_level () {
	$info = userbase();
	return (isset($info[3]) ? $info[3] : 0);
}

function user_is_login () {
	if(user_id() > 0){
		// pass
	} else {
		url_to($GLOBALS["t"]["link_login"]);
	}
}

function user_level_need ($level) {
	$info = userbase();
	return ($info[3] == $level ? true : false);
}

// function user_role_need ($role) {
// 	$info = userbase();
// 	return ($info[3] == $role ? true : false);
// }

// return user table values by current uid 
function userbase () {
	$reval = array();
	$token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : '';

	if(!empty($token)) {
		$res = sql_query("SELECT * FROM user WHERE uid = 
			(SELECT uid FROM usersess WHERE token = '". $token ."' LIMIT 1)");
		if (mysql_num_rows($res) > 0) {
			$reval = mysql_fetch_row($res);
		}
	}
	return $reval;
}

// return current user ip
function user_ip () {
	return sql_filter($_SERVER['REMOTE_ADDR']);
}

// add new user
// success return null value, failure return msg
function user_add ($arr) {
// 	$reval = l('failed to add');
	$reval = '';
	if (isset($arr["username"]) AND isset($arr["password"])) {
		$res = sql_query("SELECT uid FROM user WHERE username = '".$arr['username']."'");
		if (mysql_num_rows($res) > 0) {
			$reval = l('the user is existed');

		} else {
// 			$arr["level"] = isset($arr["level"]) ? $arr["level"] : 1;
			sql_query("INSERT INTO user(username, password, level, created) 
				VALUES ('". $arr["username"] ."','". user_encode_pwd($arr["password"]) .
				"','1', '". time() ."');"
			);
// 			$reval = l('created user successfully');
		}
	}
	return $reval;
}


/*	user action, mark down current user action, like the web server logs
	the first argument is an action name, the second is certain value what you want to mark down.
	if it has been not marked yet, return null value, others is un-null value

	for example 01, a user hits the useful action for rid 25 of record, 
	useract('useful', 25);		// success, return null value
	useract('useful', 25);		// failure, return 1

	for example 02, a user when he has been logined
	useract('login', time() + 1);	// return null value
	useract('login', time() + 2);	// return null value

	for example 03, a user when he updated the created time of record for rid 25
	useract('updated25', date('ymd'));

*/
function useract ($ukey, $uval) {
	$reval	= 1;
	$uid 	= user_id();

	$res = sql_query("SELECT uaid FROM useract WHERE uid = '$uid' AND ukey = '$ukey' AND uval = '$uval';");

	// mark down if not exists the action
	if ($res) {
		if (mysql_num_rows($res) == 0) {
			sql_query("INSERT INTO useract (uid, ukey, uval) VALUES ('". 
				$uid ."','". $ukey ."', '". $uval ."')");

			$reval = '';
		}
	}

	return $reval;
}


/*	user key-val for storing the user detail information

	for example, set value
	userinfo(1, 'nickname', 'linyu')

	for example, get value
	userinfo(1, 'nickname')	#=> 'linyu'
*/
function userinfo ($uid, $ukey, $uval = '') {
	$reval	= '';
// 	$uid 	= user_id();

	// get value
	$res = sql_query("SELECT uval FROM userinfo WHERE uid = '". $uid ."' AND ukey = '". $ukey ."' LIMIT 1");
	$num = mysql_num_rows($res);
	if ($num > 0) {
		$res 	= mysql_fetch_row($res);
		$reval 	= $res[0];
	}

	// set value
	if ($uval != '') {
		$reval = $uval;
		if ($num > 0) {
			sql_query("UPDATE userinfo SET uval = '". $uval ."' WHERE uid = '". $uid ."' AND ukey = '". $ukey ."'");
		} else {
			sql_query("INSERT INTO userinfo (uid, ukey, uval) VALUES (
				'". $uid ."','". $ukey ."', '". $reval ."')");
		}
	}

	return $reval;
}


/*	user message, 
	send message to user in post with sign like u#2, u#5

	for example, set value
	usermsg(1, 22);
	usermsg($uid, $rid);	// assume the $uid is 2, $rid is 23
	usermsg(2, 25);

	for example, get value, that will return the messages.
	usermsg(1);				// array(array('rid', 'content', 'created',,))
	usermsg(2);				// array(array('23',,,), array('25',,,)) the mysql result of record table
*/
function usermsg ($touid, $rid = 0, $msg_type = 1) {
	$reval		= array();

	// set value
	if ($rid > 0) {
		$reval 		= $rid;
		$fromuid 	= user_id();
		sql_query("INSERT INTO usermsg (fromuid, touid, rid, msg_type, created) VALUES ('". 
			$fromuid ."','". $touid ."', '". $reval ."', '". $msg_type ."', '". time() ."')");

		// set msg number
		userinfo($touid, 'new_msg', 'has');

	// get value
	} else {
// 		$reval = sql_query("SELECT * FROM record WHERE rid IN
// 			(SELECT rid FROM usermsg WHERE touid = '". $touid ."') ORDER BY rid DESC
// 		");
		$reval = sql_query("
			SELECT DISTINCT record.rid, record.content, record.follow, usermsg.created, 
				usermsg.fromuid, usermsg.msg_type FROM record 
			RIGHT JOIN usermsg ON (record.rid=usermsg.rid) 
			WHERE record.rid IN (SELECT DISTINCT usermsg.rid FROM usermsg WHERE usermsg.touid = $touid)
			ORDER BY usermsg.created DESC LIMIT 50
		");
	}

	return $reval;
}


// remind the user if the post body has the sign of calling user
// $content is record content, or something message words that could be including user sign like u#11, u#22
function user_remind($content, $rid) {
	if ($GLOBALS['t']['user_msg_open'] == 'on') {
		$reg = '/u#([0-9]{0,11})/m';
		preg_match_all($reg, $content, $matches, PREG_SET_ORDER, 0);	
		if (count($matches) > 0) {
			foreach($matches as $key => $val) {
				$uid = $val[1];

				// save msg
				usermsg($uid, $rid);
			}
		}
	}
}


/*	a copy of global config vars in config.php file, an alisa name of config vars call optionkv

	for example, set value
	optionkv('user_register_allow', 'yes');

	for example, get value
	optionkv('user_register_allow');	#=> 'yes'
*/
function optionkv ($okey, $oval = '') {
	$reval	= '';
	$uid 	= user_id();

	// get value
	$res = sql_query("SELECT oval FROM optionkv WHERE okey = '". $okey ."' LIMIT 1");
	$num = mysql_num_rows($res);
	if ($num > 0) {
		$res 	= mysql_fetch_row($res);
		$reval 	= $res[0];

	// default value
	} else {
		$reval = isset($GLOBALS['c'][$okey]) ? $GLOBALS['c'][$okey] : '';
	}

	// set value to db
	if ($oval != '') {
		$reval = $oval;
		if ($num > 0) {
			sql_query("UPDATE optionkv SET oval = '". $oval ."' WHERE okey = '". $okey ."'");
		} else {
			sql_query("INSERT INTO optionkv (uid, okey, oval) VALUES (
				'". $uid ."','". $okey ."', '". $reval ."')");
		}
	}

	return $reval;
}


/*	record logs by a key-val piece

	for example 01, set value, 
	recordlog(1, 'editor', 'guest');
	recordlog(1, 'editor', 'linyu');		// cover old value 'guest'
	recordlog(1, 'replies', 1);
	recordlog(1, 'votes', 1, true);			// auto increment by 1

	for example 02, get value, 
	recordlog(1);				#=> array('replies' => '1', 'votes' => '2', 'editor' => 'linyu')
	recordlog(1, 'editor'); 	#=> linyu

	for example 03, remove value by a key
	recordlog(1, 'hot', null);

	for example 04, remove all values by no key
	recordlog(1, null, null);

*/
function recordlog ($rid, $rkey = '', $rval = '', $increment = null) {
	$reval	= array();

	// get value
	if ($rval == '') {
		// get all
		if ($rkey == '') {
			$res = sql_query("SELECT rkey, rval FROM recordkv WHERE rid = '$rid'");
			if ($res) {
				while($row = mysql_fetch_row($res)) {
					$reval[$row[0]] = $row[1];
				}
			}
		// get by key
		} else {
			$res = sql_query("SELECT rval FROM recordkv WHERE rid = '$rid' AND rkey = '$rkey'");
			if ($res) {
				while($row = mysql_fetch_row($res)) {
					$reval = $row[0];
				}
			}
		}
	}

	// set value
	if ($rkey != '' AND $rval != '') {
		$res = sql_query("SELECT rval FROM recordkv WHERE rid = '$rid' AND rkey = '$rkey'");
		// update
		if ($row = mysql_fetch_array($res)) {
			if ($increment !== null) {
				$rval = intval($row[0]) + intval($rval);
			}
			sql_query("UPDATE recordkv SET rval = '$rval', created = '".time()."' WHERE rid = $rid AND rkey='$rkey'");
		// insert
		} else {
			sql_query("INSERT INTO recordkv (rid, rkey, rval, created) VALUES ('$rid','$rkey','$rval', '".time()."')");
		}
	}

	// remove
	if ($rval === null) {
		if ($rkey != '') {
			sql_query("DELETE FROM recordkv WHERE rid = '$rid' AND rkey = '$rkey'");
		} else {
			sql_query("DELETE FROM recordkv WHERE rid = '$rid'");
		}
	}

	return $reval;
}


/* return given field value of record table, others is null value
	
	example 01, get a field
	record_get_field(1, 'uid')		// maybe return 1, or other uid number

	example 02, return all of fields
	record_get_field(1)				// return array('uid' => 1, 'content' => 'some thing', 'created' => 111222,,,)
*/
function record_get_field ($rid, $key = '') {
	$reval = '';
	if ($rid > 0) {
		$res = sql_query('SELECT * FROM record WHERE rid = '. $rid);
		if ($row = mysql_fetch_assoc($res)) {
			if ($key == '') {
				$reval = $row;
			} else {
				$reval = $row[$key];
			}
		}
	}
	return $reval;
}


// return a invited code
function invitecode () {
	return substr(md5(date('mHd')), -6);
}


/* return validation code

	example 1, get the shot valid code
	$shotcode = validcode();			// return a rand number like 21312

	example 2, return the long valid code
	$longcode = validcode($shotcode);	// that is a md5 number return

*/
function validcode($shot_code = '') {
	$reval = '';
	// shot code
	if ($shot_code == '') {
		$reval = rand(1000, 99999);

	// long code
	} else {
		$reval = md5($shot_code . date('dh'));
	}
	return $reval;
}


/* change date to timeago

	for example

	$ptime = time();
	timeago($ptime)		#=> 0.01 hour ago 
*/
function timeago($mytime) {
	$reval		= '';
// 	$strTime	= array("second", "minute", "hour", "day", "month", "year");
// 	$length		= array("60","60","24","30","12","10");

	$ctime = time();
	if($ctime >= $mytime) {
		$diff	= $ctime - $mytime;
// 		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$reval = $diff / (60*60*24);
// 		}
		$reval = $reval > 1 ? round($reval).l(' day') : round($diff/60/60, 1).l(' hour');

// 		return $diff . " " . $strTime[$i] . "(s) ago ";
	}
	return $reval. l(' ago');
}


/* database optimized

	example 01, i want to clear records of trash
	db_task('clear10');

	example 02, clear all of user actions
	db_task('clear34');

*/
function db_task($cmd) {
	$three_month 	= time() - 60*60*24*30*3;
	$three_day 		= time() - 60*60*24*3;
	$num			= 0;

	switch ($cmd) {
		// delete records in trash
		case 'clear10' :
			$num = sql_query("DELETE FROM record WHERE cid=0;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete guest records three months ago
		case 'clear11' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND created < $three_month;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete uesless records three months ago
		case 'clear12' :
			$num = sql_query("DELETE FROM record WHERE useful=0 AND created < $three_month;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete guest and useless three months ago
		case 'clear13' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND useful=0 AND created < $three_month;", 'affect_num');
		break;

		// delete guest and useless in three days
		case 'clear14' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND useful=0 AND created > $three_day;", 'affect_num');
		break;

		// delete comment tips three months ago
		case 'clear15' :
			$num = sql_query("DELETE FROM recordkv WHERE rkey='replies' AND created < $three_month;", 'affect_num');
		break;

		// delete action logs of adding post
		case 'clear30' :
			$num = sql_query("DELETE FROM useract WHERE ukey='addpost'", 'affect_num');
		break;

		// delete action logs of adding comment
		case 'clear31' :
			$num = sql_query("DELETE FROM useract WHERE ukey='addcmt'", 'affect_num');
		break;

		// delete action logs of clicking useful btton
		case 'clear32' :
			$num = sql_query("DELETE FROM useract WHERE ukey='useful'", 'affect_num');
		break;

		// delete all of user actions there month ago
		case 'clear33' :
			$num = sql_query("DELETE FROM useract WHERE created < $three_month;", 'affect_num');
		break;

		// delete all of user actions
		case 'clear34' :
			$num = sql_query("DELETE FROM useract", 'affect_num');
		break;

		// delete all of user session
		case 'clear40' :
			$num = sql_query("TRUNCATE TABLE usersess", 'affect_num');
		break;

		// delete exp session of user
		case 'clear41' :
			$num = sql_query("DELETE FROM usersess WHERE exptime < ". time(), 'affect_num');
		break;
	}

	return $num;
}


?>
