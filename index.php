<?php

//error_reporting(0);

define("ACCESS", "ALLOW");
function access(){ defined('ACCESS') or die('Access denied'); }

// root path and dir
define("PATH_BASE",		dirname(__FILE__) . "/");

define("DIR_UPLOAD",	"others/upload/");
define('PATH_UPLOAD', 	PATH_BASE 	. DIR_UPLOAD);
define("PATH_MOD",		PATH_BASE	. "module/");

// load config file
require_once(PATH_MOD	."libs/config.php");
require_once(PATH_BASE	."others/cfg.php");

define("THEME",			$c['def_theme'] . '/');
define("PATH_THEME",	PATH_MOD	. THEME);
define("DIR_THEME",		"module/" 	. THEME);

// main programming
date_default_timezone_set($c['timezone']);
if ($c['def_mode'] == 'test') {
	ini_set("display_errors", "On");
	error_reporting(E_ALL | E_STRICT);
}
require_once(PATH_MOD	."libs/common.php");
require_once(PATH_MOD	."libs/access.php");
if (file_exists(PATH_BASE 	."others/access.php")) {
	require_once(PATH_BASE 	."others/access.php");
}

// default entrance
if (file_exists(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php')) {
	require_once(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php');
}

exit;
?>
