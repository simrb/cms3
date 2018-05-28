<?php access();


$c = array();	// global config
$t = array();	// template var


$c['version'] 			=	'v1.0.2';
$c['sql_server']		=	'localhost';
$c['sql_user'] 			=	'cms_user';
$c['sql_pawd'] 			=	'cms_pawd';
$c['sql_dbname'] 		=	'cms_db';

// test, development, production
$c['def_mode'] 			=	'test';
$c['def_lang'] 			=	'en';
$c['def_theme'] 		=	'theme';
$c['def_pagesize'] 		=	20;
$c['sn'] 				=	'sn_code';
$c['timezone'] 			=	'Asia/Shanghai';

// the i of H:i:s
$c['last_post_time'] 	=	'1';
$c['last_post_ip'] 		=	'0.0.0.0';

// image format
$c['img_allow_types'] 	=	array('jpg','jpeg','gif','png');
$c['img_max_size'] 		=	3000000;		// 3 MB
$c['img_max_width'] 	=	'1000';
$c['img_max_height'] 	=	'1000';




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
								2 => 'front edit',
								3 => 'view',
								6 => 'view, edit',
								9 => 'view, edit, add user',
							);


$t['admin_menu'] 		=	array(
							array(
								'head'	=>	array('records' =>	'img/6.png'),
								'body'	=>	array(
									'record list'	=>	'?_m=admin&_f=record',
// 									'add'			=>	'?_m=admin&_f=record&_v=edit',
									'clear up'		=>	'?_m=admin&_f=record&_v=optimize',
								),
							),

							array(
								'head'	=>	array('options' =>	'img/1.png'),
								'body'	=>	array(
									'category'		=>	'?_m=admin&_f=category',
									'file'			=>	'?_m=admin&_f=file',
									'info'			=>	'?_m=admin&_f=main&_v=info',
								),
							),

							array(
								'head'	=>	array('users' =>	'img/8.png'),
								'body'	=>	array(
									'user list'		=>	'?_m=admin&_f=user',
									'status'		=>	'?_m=admin&_f=user&_v=status',
								),
							),

);




?>
