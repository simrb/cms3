<?php 

//error_reporting(0);

// base paths
define("ACCESS", "ALLOW");
function access(){ defined('ACCESS') or die('Access denied'); }
date_default_timezone_set('Asia/Shanghai');
define("PATH_BASE",		dirname(__FILE__) . "/");


// absolute path
define("PATH_MOD",		PATH_BASE . "apps/");
define("PATH_RES",		PATH_BASE . "apps/theme/");
define('PATH_UPLOAD', 	PATH_BASE . 'data/upload/');

// relative path
define("DIR_RES",		"apps/theme/");
define("DIR_UPLOAD",	"data/upload/");


// config, common func, access file
require_once(PATH_BASE	."cfg.php");
require_once(PATH_MOD	."common.php");
require_once(PATH_BASE 	."access.php");

// index file
require_once(PATH_MOD . $t['_m'].'/'.$t['_f'].'.php');

exit;
?>
