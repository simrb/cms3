<?php

//error_reporting(0);

// base paths
define("ACCESS", "ALLOW");
function access(){ defined('ACCESS') or die('Access denied'); }
date_default_timezone_set('Asia/Shanghai');

// base path
define("PATH_BASE",		dirname(__FILE__) . "/");

// default config
require_once(PATH_BASE	."others/cfg.php");

// absolute path
define("PATH_MOD",		PATH_BASE . "module/");
define("PATH_THEME",	PATH_BASE . "module/theme/");
define('PATH_UPLOAD', 	PATH_BASE . 'others/upload/');

// relative path
define("DIR_THEME",		"module/theme/");
define("DIR_UPLOAD",	"others/upload/");

// common libs, default access
require_once(PATH_MOD	."data/common.php");
require_once(PATH_BASE 	."others/access.php");

// index file
if (file_exists(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php')) {
	require_once(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php');
}

exit;
?>
