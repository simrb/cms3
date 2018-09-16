<?php access();


// filter sql injections
$_GET 		= sql_filter($_GET);
$_POST		= sql_filter($_POST);
$_REQUEST	= sql_filter($_REQUEST);
$_COOKIE	= sql_filter($_COOKIE);
// $_SERVER	= sql_filter($_SERVER);


// set module, file, action, view
// $str	= isset($_GET['_r']) ? $_GET['_r'] : '';
// $arr	= explode('_', $str);
// foreach (array(0 => '_m', 1 => '_f', 2 => '_a', 3 => '_v') as $key => $val) {
// 	if(isset($arr[$key]) and !empty($arr[$key])) { $t[$val] = $arr[$key]; }
// }

foreach (array('_m', '_f', '_a', '_v') as $val) {
	if(isset($_GET[$val]) and !empty($_GET[$val])) { $t[$val] = $_GET[$val]; }
}


// set auth in access entrance
if ($t['_m'] == 'admin') {

	$def_layout 	= (user_level() > 0) ? VIEW_DIR.'admin/layout' : VIEW_DIR.'layout';

	$t['tpl_dir'] 		= VIEW_DIR.$t['_m'].'/';
	$t['tpl_name'] 		= $t['_f'];

	// remove user menu
	if (user_level() < 9) {
		array_pop($t['admin_menu']);
	}

	switch ($t['_f']) {
		case 'main':
		case 'category':
		case 'file':
		case 'record':
			if (user_level() < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;

		case 'user':
			// user login
			if (($t['_v'] == "login") or ($t['_a'] == "login") or ($t['_a'] == "logout") or ($t['_v'] == "getvcode") ) {
				// pass

			} else {
				if (user_level() < 9) {
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
			if (user_level() < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;
		default:
	}

	switch ($t['_v']) {
		case 'info':
		case 'edit':
			if (user_level() < 6) {
				out(l("no privilege to access"), $t, $def_layout);
			}
			break;
		default:
	}

}

?>
