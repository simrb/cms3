<?php access();



// return the dir path, if it is`t existed, just creates it
function path_dir ($path) {
	$path = PATH_MOD.$path.'/';
	mk_dir($path);
	return $path;
}


function mk_dir($dir, $mode = 0777) {
	if (is_dir($dir) || @mkdir($dir,$mode)) return true;
	if (!mk_dir(dirname($dir),$mode)) return false;
	return @mkdir($dir,$mode);
} 


// return the real path for static resource file, like js, css
function path_theme ($path) {
	$path = DIR_THEME . $path;
	if (!file_exists($path)) {
		$path = "no file $path";
	}
	return $path;
}


// return complete template path
function path_tmp ($path) {
	return PATH_MOD.$path.'.tpl';
}


// load a template by tpl name, or no layout with $layout = 'unlayout'
function tmp($t, $tpl_name = '', $layout = '') {

	$t['web_logo']		=	optionkv('web_logo');
	$t['web_header']	=	optionkv('web_header');

	$t["msg"]			=	isset($t["msg"]) ? date("Y-m-d H:i:s")." ".$t["msg"] : "";
	$t["tpl_name"] 		=	$t["tpl_dir"].$t["tpl_name"];
	$t["tpl_layout"] 	=	$t["tpl_dir"].$t["tpl_layout"];

	if ($tpl_name != '') {
		$t["tpl_name"]	=	$tpl_name;
	}

	if ($layout != '') {
		$t["tpl_layout"]	=	$layout;
	}

	// load template 
// 	if (empty($t["tpl_layout"])) {
	if ($layout == 'unlayout') {
		include_once(path_tmp($t['tpl_name']));
	// load layout
	} else {
		include_once(path_tmp($t["tpl_layout"]));
	}
}


function out($str, $t, $layout = '') {
	$t["msg"] = $str;
	//$t["blank"] = $str;
	$t['tpl_dir'] = THEME;
	$t["tpl_layout"] = 	$layout != '' ? $layout : (THEME.'layout');
	tmp($t, THEME.'blank', $t["tpl_layout"]);
	exit;
}


// change the language from en to what you want
function l ($str) {
	$reval 	= $str;
	$path 	= PATH_THEME . 'lang/' . $GLOBALS['c']['def_lang'] . '.php';
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


// complete the url for option _m, _f
function url_c ($str = '') {
	$url = isset($GLOBALS["t"]['url']) ? $GLOBALS["t"]['url'] : '';
	$str = '?_m='. $GLOBALS["t"]['_m']. '&_f='. $GLOBALS["t"]['_f'] . '&' . $str . '&' . $url ;
	return $str;
}


// jump to somewhere
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


// return a key-val result that getting from database by a table and two fields given
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

	$conn = mysql_connect($GLOBALS['c']['sql_server'], $GLOBALS['c']['sql_user'], $GLOBALS['c']['sql_pawd']) 
		or die("Could not connect: " . mysql_error());

	mysql_select_db($GLOBALS['c']['sql_dbname'], $conn) 
		or die ("Can't use db ". $GLOBALS['c']['sql_dbname'] . mysql_error());

	$result = mysql_query($sql) 
		or die("Could not query: " . mysql_error());	

	if ($op == 'insert_id') {
		$result = mysql_insert_id();
	} elseif ($op == 'affect_num') {
		$result = mysql_affected_rows();
	}

	mysql_close($conn);

	return $result;
}

function sql_filter_str($str) {
    $str = str_replace(array("'", '"'), array("&apos;","&quot;"), $str);
    return $str;
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

//a simple bbcode Parser function
function show_bbcodes($text) {

	$text = htmlspecialchars($text);

	// BBcode array
	$find = array(
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[size=(.*?)\](.*?)\[/size\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
		'/\[url\=(.*?)\](.*?)\[\/url\]/is',
		'/\[img\=(\d*?)x(\d*?)\](.*?)\[\/img\]/is',
		'~\[img\](.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
		'~\[embed\]((?:ftp|https?)://.*?)\[/embed\]~s',
		'~\[video\]((?:ftp|https?)://.*?)\[/video\]~s',
	);

	// HTML tags to replace BBcode
	$replace = array(
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<pre>$1</'.'pre>',
		'<span style="font-size:$1px;">$2</span>',
		'<span style="color:$1;">$2</span>',
		'<a href="$1" target="_blank" >$1</a>',
		'<a href="$2" target="_blank" >$1</a>',
		'<img height="$2" width="$1" src="$3" />',
		'<img src="$1" />',
		'<embed src="$1" autostart="false" />',
		'<video controls="" src="$1" ></video>',
	);

	// Replacing the BBcodes with corresponding HTML tags
	return preg_replace($find, $replace, $text);
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
					username = '". $name ."' AND password ='". $pawd ."' ;");

	if (mysql_num_rows($res) > 0) {
		$row 	= mysql_fetch_row($res);
		$token	= md5($row[0] + date('YmdHis'));
		$time	= time()+3600*24*7;

		// set the user info for login, expire time in 7 days
		setcookie("token", $token, $time);

		// save a token
		sql_query("INSERT INTO sess (uid, token, created, exptime) VALUES (
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
		sql_query("DELETE FROM sess WHERE token = '$token'");
	}
}

// return the user id current he logined
function user_id () {
	$info = user_info();
	return (isset($info[0]) ? $info[0] : 0);
}

// return the user name 
function user_name () {
	$info = user_info();
	return (isset($info[1]) ? $info[1] : 'default');
}

// return the user level
function user_level () {
	$info = user_info();
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
	$info = user_info();
	return ($info[3] == $level ? true : false);
}

// remove at new version
function user_role_need ($role) {
	$info = user_info();
	return ($info[3] == $role ? true : false);
}

// retunr an array of user info
function user_info () {
	$reval = array();
	$token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : '';

	if(!empty($token)) {
		$res = sql_query("SELECT * FROM user WHERE uid = 
			(SELECT uid FROM sess WHERE token = '". $token ."' LIMIT 1)");
		if (mysql_num_rows($res) > 0) {
			$reval = mysql_fetch_row($res);
		}
	}
	return $reval;
}

// get current user ip
function user_ip () {
	return $_SERVER['REMOTE_ADDR'];
}

// return value by key
function optionkv ($okey) {

	$reval	= '';
	$uid 	= user_id();

	// has okey in db
	$res = sql_query("SELECT oval FROM optionkv WHERE okey = '". $okey ."' LIMIT 1");
	if (mysql_num_rows($res) > 0) {
		$res2 	= mysql_fetch_row($res);
		$reval 	= $res2[0];

	// no okey, then fetch it from $c, and write to db
	} else {
		$reval = isset($GLOBALS['c'][$okey]) ? $GLOBALS['c'][$okey] : 'null';
		sql_query("INSERT INTO optionkv (uid, okey, oval) VALUES (
			'". $uid ."','". $okey ."', '". $reval ."')");
	}

	return $reval;
}

// set oval by okey
function optionkv_set ($okey, $oval) {
	$uid = user_id();
	sql_query("UPDATE optionkv SET oval = '". $oval ."' WHERE okey = '". $okey ."'");
}

function user_allow_submit () {
	$reval = '';

	if (optionkv('last_post_ip') == user_ip()) {
		// time
		if (abs(intval(date("i")) - intval(optionkv('last_post_time'))) < 2) {
			$reval = l('you cannot post twice in a short time');
		}
	} else {
		optionkv_set('last_post_ip', user_ip());
	}
	optionkv_set('last_post_time', date("i"));

	return $reval;
}

function user_add ($arr) {
	$reval = l('failed to add');
	if (isset($arr["username"])) {
		$res = sql_query("SELECT uid FROM user WHERE username = '".$arr['username']."'");
		if (mysql_num_rows($res) > 0) {
			$reval = l('the user is existed');

		} else {
			sql_query("INSERT INTO user(username, password, level, created) 
				VALUES ('". $arr["username"] ."','". $arr["password"] .
				"','". $arr["level"] ."', '". time() ."');"
			);
			$reval = l('created user successfully');
		}
	}
	return $reval;
}

function record_get_content ($rid = 0) {
	$reval = l('nothing');
	if ($rid != 0) {
		$res = sql_query('SELECT content FROM record WHERE rid = '. $rid);
		if ($row = mysql_fetch_assoc($res)) {
			$reval = $row['content'];
		}
	}
	return $reval;
}



/*
$_REQUEST	= sql_filter($_REQUEST);
$_GET 		= sql_filter($_GET);
$_POST		= sql_filter($_POST);
*/

?>
