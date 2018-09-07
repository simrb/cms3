<?php access();


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


//act: delsess
if ($t['_a'] == "delsess") {
	if (isset($_GET['exp'])) {
		sql_query("DELETE FROM sess WHERE exptime < ". time());
		$t["msg"] = l('deleted successfully');
	} else {
		sql_query("TRUNCATE TABLE sess;");
		$t["msg"] = l('deleted successfully, you will quit soon');
	}
}


//act: logout
if ($t['_a'] == "logout") {
	user_logout();
	url_to ();
}


//act: get_vcode_img of ajax
if ($t['_v'] == "getvcode") {
	$shotcode = validcode();
	$longcode = validcode($shotcode);

	// size
	$im = imagecreatetruecolor(60, 20);

	// draw font
	$text_color = imagecolorallocate($im, 255, 255, 255);
	imagestring($im, 5, 5, 2, $shotcode, $text_color);

	// draw line
	imageline($im, rand(1,9), rand(1,20), rand(30,50), rand(1,10), $text_color);


	// set cookie, header type, image
	setcookie("val22", $longcode, time()+60*2);
	header('Content-Type: image/jpeg');
	imagejpeg($im, NULL, 75);

	// free up memory
	imagedestroy($im);

	exit;
}


//act: login and register
if ($t['_a'] == "login") {
	$valid_error = 0;
	$t['msg'] = '';
	
	// check username, password
	if (isset($_POST["username"]) AND isset($_POST["password"])) {
		// pass
	} else {
		$valid_error = 1;
	}

	// check the invide code
	if ( $t['user_icode_open'] == 'on' ) {
		if (isset($_POST["invitecode"]) AND ($_POST["invitecode"] == invitecode())) {
			// pass
		} else {
			$valid_error = 1;
			$t['msg'] .= l('the invite code is wrong');
		}
	}

	// check the validate code
	// val22 is the long vcode
	if ( $t['user_vcode_open'] == 'on' ) {
		if (isset($_POST["shot_vcode"]) AND isset($_COOKIE["val22"])) {
			if ($_COOKIE["val22"] != validcode($_POST["shot_vcode"])) {
				$valid_error = 1;
				$t['msg'] .= l('the validate code is wrong');
			}
		} else {
			$valid_error = 1;
			$t['msg'] .= l('the validate code is wrong');
		}

		// remove validate code
		unset($_COOKIE["val11"]);
		setcookie("val22", '', -1);
	}

	// validate pass
	if ($valid_error == 0) {
		// user register
		if (isset($_POST["firstime"]) AND $t['user_reg_open'] == 'on') {
				$arr = $_POST;
				$arr['level'] = 1;
				$t['msg'] = user_add($arr);

		// user login
		} else {
			if (user_login($_POST['username'], $_POST['password'])) {
				$t['msg'] = l('login successfully');
				url_to(url_referer());
			} else {
				$t['msg'] .= l('failed to login, the username and password is not matched');
			}
		}
	}

	$t['msg'] .= " <a href='".$t["link_login"]."'>". l('return') ."</a>";
	$t['tpl_dir'] = VIEW_DIR;
	out($t['msg'], $t);
}


//view: login
if ($t['_v'] == "login") {
	// has login yet
	if(user_id() > 0){
		$t['tpl_dir'] = VIEW_DIR;
		out(l('you have login yet'), $t);
	} else {
		$t['aboutuser'] = record_get_content($t['rid_aboutuser']);
		url_referer('?');
// 		$t['shot_code'] = validcode();
// 		$t['val22'] = validcode($t['shot_code']);
		tpl($t, $t['tpl_dir']."login", VIEW_DIR.'layout');
	}
}


//view: show
if ($t['_v'] == "show") {
	
	$sql 		= "SELECT * FROM user";
	$pagesize 	= isset($_GET['pagesize']) ? $_GET['pagesize'] : 20;

	if (isset($_POST['select_key']) and isset($_POST['select_val'])) {
		$sql .= ' WHERE '. $_POST['select_key'] . ' = "'. $_POST['select_val'] .'";';
	} else {
		$sql .= ' ORDER BY uid DESC LIMIT '. $pagesize .';';
	}

	$t["user_res"] = sql_query($sql);
	tpl($t);
}


//view: status
if ($t['_v'] == "status") {
	$t["user_res"] = sql_query("SELECT * FROM sess ORDER BY sid DESC LIMIT 20;");
	tpl($t, $t['tpl_dir']."sess");
}


//view: edit
if ($t['_v'] == "edit") {
	$t["uid"]			=	isset($t["uid"]) ? $t["uid"] : 0;
	$t["username"]		=	isset($t["username"]) ? $t["username"] : "";
	$t["password"]		=	isset($t["password"]) ? $t["password"] : "";
	$t["level"]			=	isset($t["level"]) ? $t["level"] : "";
	$t['_a']			=	$t['_a'] == "" ? "add" : $t['_a'];
	$t["user_level"]	=	$t['user_level'];

	//fetch the data that will be changed later
	if (isset($_GET["uid"])) {
		$res = sql_query("SELECT * FROM user WHERE uid = '". $_GET["uid"] ."';");
		if ($res) {
			$row = mysql_fetch_assoc($res);
			$t["uid"]			=	$row['uid'];
			$t["username"]		=	$row['username'];
			$t["password"]		=	$row['password'];
			$t["level"]			=	$row['level'];
			$t['_a']			=	"update";
		}
	}
	tpl($t);
}


?>
