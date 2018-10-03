<?php access();


$c = array();	// global config
$t = array();	// template var

$c['version'] 			=	'v1.0.3.3';
$c['def_view'] 			=	'view';		// default theme

// open file
//		vi /etc/httpd/conf/httpd.conf
// change 
// 		<Directory "/var/www/html">
//			AllowOverride None
// to 
// 		<Directory "/var/www/html">
//			AllowOverride All
// end, restart server
//		/etc/init.d/httpd restart
$c['seo_open'] 			=	'off';

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

$t['ip_type'] 		=	array(
								1 => 'block ip',
								2 => 'allow ip',
);

$t['admin_menu'] 		=	array(
								array(
									'head'	=>	array('records' =>	'img/6.png'),
									'body'	=>	array(
										'record list'	=>	'?_m=admin&_f=record',
	// 									'add'			=>	'?_m=admin&_f=record&_v=edit',
										'optimize'		=>	'?_m=admin&_f=record&_v=optimize',
										'defence'		=>	'?_m=admin&_f=main&_v=defence',
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

// record id
$t['rid_aboutme'] 		=	1;
$t['rid_aboutuser'] 	=	2;
$t['rid_aboutpost'] 	=	3;
$t['rid_comment'] 		=	4;

// user function
$t['user_defence'] 		=	'on';		// open the defence mode
$t['user_msg_open'] 	=	'on';		// allow message using
$t['user_reg_open'] 	=	'on';		// allow user register
$t['user_login_open'] 	=	'on';		// allow user login
$t['user_vcode_open'] 	=	'on';		// user validate code for login and register
$t['user_icode_open'] 	=	'off';		// user invide code for register


?>
