<?php

//error_reporting(0);

// base paths
define("ACCESS", "ALLOW");
function access(){ defined('ACCESS') or die('Access denied'); }
date_default_timezone_set('Asia/Shanghai');
define("PATH_BASE",		dirname(__FILE__) . "/");

// absolute path
define("PATH_MOD",		PATH_BASE . "module/");
define("PATH_RES",		PATH_BASE . "module/theme/");
define('PATH_UPLOAD', 	PATH_BASE . 'others/upload/');

// relative path
define("DIR_RES",		"module/theme/");
define("DIR_UPLOAD",	"others/upload/");

// default config
require_once(PATH_BASE	."others/cfg.php");
require_once(PATH_MOD	."admin/common.php");
require_once(PATH_BASE 	."others/access.php");

// index file
require_once(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php');

exit;
?>
