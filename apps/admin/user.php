<?php access();
$t['layout'] = 'admin/tpl/layout';

//act: add
if ($t['_a'] == "add") {
	$t["msg"] = user_add($_POST);
}


//act: update
if ($t['_a'] == "update") {
	if (isset($_POST["uid"]) and isset($_POST["username"])) {
		sql_query("UPDATE user SET 
			username = '". $_POST["username"] ."',
			password = '". $_POST["password"] ."',
			level = '". $_POST["level"] ."' 
			WHERE uid = '".$_POST["uid"]."';"
		);

		$res = sql_query("SELECT * FROM user WHERE uid = '". $_POST["uid"] ."';");
		if ($res) {
			$row = mysql_fetch_row($res);
			$t["uid"]			=	$row[0];
			$t["username"]		=	$row[1];
			$t["password"]		=	$row[2];
			$t["level"]			=	$row[3];
			$t['_a']			=	"update";
			$t["msg"] 			= 	l('updated successfully');
		}
	}
}


//act: delete
if ($t['_a'] == "del") {
	if (isset($_GET["uid"])) {
		sql_query("DELETE FROM user WHERE uid='". $_GET["uid"] ."';");
		$t["msg"] = l('deleted successfully');
	}
}


//act: delall
if ($t['_a'] == "delall") {
	sql_query("TRUNCATE TABLE user_status;");
	$t["msg"] = l('deleted successfully, you will quit soon');
}


//act: logout
if ($t['_a'] == "logout") {
	user_logout();
	url_to ();
}


//act: login and register
if ($t['_a'] == "login") {
	$t["msg"] = l('failed to login, the username and password is not matched').
		" <a href='".$GLOBALS["ucfg"]["user_login_page"]."'>". l('return') ."</a>";

	if (isset($_POST["username"]) and isset($_POST["password"])) {
		// user register
		if (isset($_POST["firstime"]) and $_POST["firstime"] == 'yes') {
			$arr = $_POST;
			$arr['level'] = 1;
			$t["msg"] = user_add($arr);
		}

		// user login
		if (user_login($_POST['username'], $_POST['password'])) {
			url_to(url_referer());
		}
	}

	out($t["msg"], $t);
}


//view: login
if ($t['_v'] == "login") {
	$t['layout'] = 'layout';
	// has login yet
	if(user_id() > 0){
		$t['blank'] = l('you have login yet');
		tmp('theme/blank', $t);
	} else {
		url_referer('?');
		tmp("admin/tpl/login", $t);
	}
}


//view: show
if ($t['_v'] == "show") {
	
	$sql 		= "SELECT * FROM user";
	$pagesize 	= isset($_GET['pagesize']) ? $_GET['pagesize'] : 10;
	if (isset($_POST['select_key']) and isset($_POST['select_val'])) {
		$sql .= ' WHERE '. $_POST['select_key'] . ' = "'. $_POST['select_val'] .'";';
	} else {
		$sql .= ' ORDER BY uid DESC LIMIT '. $pagesize .';';
	}

	$t["user_res"] = sql_query($sql);
	tmp("admin/tpl/user", $t);
}


//view: status
if ($t['_v'] == "status") {
	$t["user_res"] = sql_query("SELECT * FROM user_status ORDER BY usid DESC LIMIT 20;");
	tmp("admin/tpl/user_status", $t);
}


//view: edit
if ($t['_v'] == "edit") {
	$t["uid"]			=	isset($t["uid"]) ? $t["uid"] : 0;
	$t["username"]		=	isset($t["username"]) ? $t["username"] : "";
	$t["password"]		=	isset($t["password"]) ? $t["password"] : "";
	$t["level"]			=	isset($t["level"]) ? $t["level"] : "";
	$t['_a']			=	$t['_a'] == "" ? "add" : $t['_a'];
	$t["user_level"]	=	$ucfg['user_level'];

	//fetch the data that will be changed later
	if (isset($_GET["uid"])) {
		$res = sql_query("SELECT * FROM user WHERE uid = '". $_GET["uid"] ."';");
		if ($res) {
			$row = mysql_fetch_row($res);
			$t["uid"]			=	$row[0];
			$t["username"]		=	$row[1];
			$t["password"]		=	$row[2];
			$t["level"]			=	$row[3];
			$t['_a']			=	"update";
		}
	}
	tmp("admin/tpl/user", $t);
}


function user_add ($arr) {
	$reval = l('failed to add');
	if (isset($arr["username"])) {
		sql_query("INSERT INTO user(username, password, level) 
			VALUES ('". $arr["username"] ."','". $arr["password"] .
			"','". $arr["level"] ."');"
		);
		$reval = l('added successfully');
	}
	return $reval;
}

?>
