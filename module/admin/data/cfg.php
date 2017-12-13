<?php access();


// global config
$c = array(
	'sql_server'		=>	'localhost',
	'sql_user' 			=>	'cms_user',
	'sql_pawd'			=>	'cms_pawd',
	'sql_dbname'		=>	'cms_db',

	'def_mode'			=>	'test',		// test, development, production
	'def_lang'			=>	'en',
	'def_theme'			=>	'theme',
	'def_pagesize'		=>	20,
	'version'			=>	'v1.0.3',

	'last_post_ip' 		=>	'0.0.0.0',
	'last_post_time' 	=>	'1',			// the i of H:i:s
);


// template var
$t = array(
	// default module, file, action, view
	'_m'				=>	'front',
	'_f'				=>	'main',
	'_a'				=>	'',
	'_v'				=>	'show',

	'tpl_dir'			=>	'theme/front/',
	'tpl_layout'		=>	'layout',

	'link_login'		=>	'?_m=admin&_f=user&_v=login',
	'link_logout'		=>	'?_m=admin&_f=user&_a=logout',

	// default page info
	'web_title' 		=>	"NEW SITE",
	'web_header' 		=>	"NEW SITE",
	'web_name' 			=>	"scms",
	'web_des'			=>	'',
	'web_kw'			=>	'',
	'web_logo' 			=>	"",
	'web_footer'		=>	"Powered by linyu, 2016-",

	'user_level'		=>	array(
								1 => 'front',
								3 => 'view',
								6 => 'view, edit',
								9 => 'view, edit, add user',
						),
);



if ($c['def_mode'] == 'test') {
	ini_set("display_errors", "On");
	error_reporting(E_ALL | E_STRICT);
}

?>
