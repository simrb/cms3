<?php

// error_reporting(0);

define("ACCESS", "ALLOW");
function access(){ defined('ACCESS') or die('Access denied'); }

// project path and dir
define("PROJECT_PATH",	dirname(__FILE__) . "/");
define("MODULE_PATH",	PROJECT_PATH );

define("UPLOAD_DIR",	"others/upload/");
define('UPLOAD_PATH', 	PROJECT_PATH . UPLOAD_DIR);

// load config file
require_once(MODULE_PATH	."lib/config.php");
require_once(PROJECT_PATH	."others/cfg.php");

define("VIEW_DIR",		$c['def_view'] . '/');

// main programming
date_default_timezone_set($c['timezone']);
if ($c['def_mode'] == 'test') {
	ini_set("display_errors", "On");
	error_reporting(E_ALL | E_STRICT);
} else {
	error_reporting(0);
}
require_once(MODULE_PATH	."lib/func.php");
require_once(MODULE_PATH	."lib/access.php");
if (file_exists(PROJECT_PATH 	."others/access.php")) {
	require_once(PROJECT_PATH 	."others/access.php");
}

// default entrance
if (file_exists(MODULE_PATH . $t['_m'].'/'.$t['_f'].'.php')) {
	require_once(MODULE_PATH . $t['_m'].'/'.$t['_f'].'.php');
}

exit;
?>
