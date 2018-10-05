<?php access();

// refuse bad ip
defence_ip();

// filter sql injections
$_GET 		= sql_filter($_GET);
$_POST		= sql_filter($_POST);
$_REQUEST	= sql_filter($_REQUEST);
$_COOKIE	= sql_filter($_COOKIE);
// $_SERVER	= sql_filter($_SERVER);

$user_level	= user_level();

// running at back-end
if (isset($argv[1])) {
	foreach ($argv as $arg) {
		$e = explode("=",$arg);
		$_GET[$e[0]] = count($e) >=2 ? $e[1] : 0 ;
	}

	$user_level	= 9;
}

foreach (array('_m', '_f', '_a', '_v') as $val) {
	if(isset($_GET[$val]) and !empty($_GET[$val])) { $t[$val] = $_GET[$val]; }
}

// set auth in access entrance
if ($t['_m'] == 'admin') {

	// set default layout
	$def_layout 		= $user_level > 5 ? 'alayout' : 'flayout';
 	$t['tpl_layout'] 	= $def_layout;

	// remove user menu
	if ($user_level < 9) {
		array_pop($t['admin_menu']);
	}

	switch ($t['_f']) {
		case 'main':
		case 'category':
		case 'file':
		case 'record':
			if ($user_level < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;

		case 'user':
			// user login
			if (($t['_v'] == "login") or ($t['_a'] == "login") or ($t['_a'] == "logout") or ($t['_v'] == "getvcode") ) {
				// pass

			} else {
				if ($user_level < 9) {
					out(l("no privilege to access"), $t, $def_layout);
				}
			}
			break;

		default:
	}

	switch ($t['_a']) {
		case 'add':
		case 'edit':
		case 'del':
		case 'delall':
		case 'update':
			if ($user_level < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;
		default:
	}

	switch ($t['_v']) {
		case 'info':
		case 'edit':
			if ($user_level < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;
		default:
	}

}

?>
