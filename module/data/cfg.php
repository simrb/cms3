<?php access();


// global config
$c = array(
	'sql_server'		=>	'localhost',
	'sql_user' 			=>	'cms_user',
	'sql_pawd'			=>	'cms_pawd',
	'sql_dbname'		=>	'cms_db',

	'def_mode'			=>	'test',		// test or others like devel, production
	'def_lang'			=>	'en',
	'def_pagesize'		=>	20,
	'version'			=>	'v3.0.0',

	'last_post_ip' 		=>	'0.0.0.0',
	'last_post_time' 	=>	'1',			// 'the i of H:i:s'
);


// template var
$t = array(
	// default module, file, action, view
	'_m'				=>	'front',
	'_f'				=>	'main',
	'_a'				=>	'',
	'_v'				=>	'show',

	'def_layout'		=>	'front/tpl/layout',
	'def_login'			=>	'?_m=admin&_f=user&_v=login',
	'def_logout'		=>	'?_m=admin&_f=user&_a=logout',

	// default page info
	'web_title' 		=>	"A SITE",
	'web_header' 		=>	"NEW SITE",
	'web_name' 			=>	"CMS",
	'web_des'			=>	'',
	'web_kw'			=>	'',
	'web_logo' 			=>	"",
	'web_footer'		=>	"Copyleft © 2016-",

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
