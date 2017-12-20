<?php access();


$c = array();	// global config
$t = array();	// template var


$c['sql_server']		=	'localhost';
$c['sql_user'] 			=	'cms_user';
$c['sql_pawd'] 			=	'cms_pawd';
$c['sql_dbname'] 		=	'cms_db';

// test, development, production
$c['def_mode'] 			=	'test';
$c['def_lang'] 			=	'en';
$c['def_theme'] 		=	'theme';
$c['def_pagesize'] 		=	20;
$c['version'] 			=	'v1.0.1';
$c['sn'] 				=	'sn_code';
$c['timezone'] 			=	'Asia/Shanghai';

$c['last_post_ip'] 		=	'0.0.0.0';

// the i of H:i:s
$c['last_post_time'] 	=	'1';


// default module, file, action, view
$t['_m'] 				=	'front';
$t['_f'] 				=	'main';
$t['_a'] 				=	'';
$t['_v'] 				=	'show';

$t['tpl_name'] 			=	'index';
$t['tpl_dir'] 			=	'theme/front/';
$t['tpl_layout'] 		=	'layout';

$t['link_login'] 		=	'?_m=admin&_f=user&_v=login';
$t['link_logout'] 		=	'?_m=admin&_f=user&_a=logout';

// record id
$t['rid_aboutme'] 		=	1;
$t['rid_aboutuser'] 	=	2;
$t['rid_aboutpost'] 	=	3;
$t['rid_comment'] 		=	4;

// default page info
$t['web_title'] 		=	'NEW SITE';
$t['web_header'] 		=	'NEW SITE';
$t['web_name'] 			=	'scms';
$t['web_des'] 			=	'NEW SITE';
$t['web_kw'] 			=	'NEW SITE';
$t['web_logo'] 			=	'';
$t['web_footer'] 		=	'Powered by linyu, 2016-';


$t['user_level'] 		=	array(
								1 => 'front',
								3 => 'view',
								6 => 'view, edit',
								9 => 'view, edit, add user',
							);



?>
