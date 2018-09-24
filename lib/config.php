<?php access();


$c = array();	// global config
$t = array();	// template var


$c['version'] 			=	'v1.0.3.3';
$c['def_view'] 			=	'view';		// default theme


// default module, file, action, view
$t['_m'] 				=	'front';
$t['_f'] 				=	'main';
$t['_a'] 				=	'';
$t['_v'] 				=	'show';

$t['tpl_name'] 			=	'index';
$t['tpl_dir'] 			=	$c['def_view'].'/';
$t['tpl_layout'] 		=	'flayout';

$t['web_style'] 		=	'front';


$t['link_login'] 		=	'?_m=admin&_f=user&_v=login';
$t['link_logout'] 		=	'?_m=admin&_f=user&_a=logout';
$t['link_register'] 	=	'?_m=admin&_f=user&_v=login&firstime=yes';


$t['user_level'] 		=	array(
								1 => 'front add',
								5 => 'front add, edit',
								6 => 'front edit, admin edit',
								9 => 'front edit, admin edit, user edit',
						);


$t['admin_menu'] 		=	array(
								array(
									'head'	=>	array('records' =>	'img/6.png'),
									'body'	=>	array(
										'record list'	=>	'?_m=admin&_f=record',
	// 									'add'			=>	'?_m=admin&_f=record&_v=edit',
										'optimize'		=>	'?_m=admin&_f=record&_v=optimize',
									),
								),

								array(
									'head'	=>	array('options' =>	'img/1.png'),
									'body'	=>	array(
										'category'		=>	'?_m=admin&_f=category',
										'file'			=>	'?_m=admin&_f=file',
										'settings'		=>	'?_m=admin&_f=main&_v=info',
									),
								),

								array(
									'head'	=>	array('users' =>	'img/8.png'),
									'body'	=>	array(
										'user list'		=>	'?_m=admin&_f=user',
										'status'		=>	'?_m=admin&_f=user&_v=status',
										'backup'		=>	'?_m=admin&_f=main&_v=backup',
									),
								),

						);




?>
