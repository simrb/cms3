<?php access();

// database
$c['sql_server']		=	'localhost';
$c['sql_user'] 			=	'cms_user';
$c['sql_pawd'] 			=	'cms_pawd';
$c['sql_dbname'] 		=	'cms_db';


// settings
$c['sn'] 				=	'sn_code';
$c['def_mode'] 			=	'test';		// test, development, production
$c['def_lang'] 			=	'en';		// en, cn
$c['def_pagesize'] 		=	20;
$c['timezone'] 			=	'Asia/Shanghai';


// image format
$c['img_allow_types'] 	=	array('jpg','jpeg','gif','png');
$c['img_max_size'] 		=	3000000;		// 3 MB
$c['img_max_width'] 	=	'1000';
$c['img_max_height'] 	=	'1000';


// default page info
$t['web_title'] 		=	'NEW SITE';
$t['web_header'] 		=	'NEW SITE';
$t['web_name'] 			=	'scms';
$t['web_des'] 			=	'NEW SITE';
$t['web_kw'] 			=	'NEW SITE';
$t['web_logo'] 			=	'';
$t['web_style'] 		=	'fwhite';
$t['web_footer'] 		=	'Initialize by linyu, 2016-';


// record id
$t['rid_aboutme'] 		=	1;
$t['rid_aboutuser'] 	=	2;
$t['rid_aboutpost'] 	=	3;
$t['rid_comment'] 		=	4;


// user function
$t['user_reg_open'] 	=	'on';	// allow user register
$t['user_msg_open'] 	=	'on';	// allow message using
$t['user_vcode_open'] 	=	'on';	// user validate code for login and register
$t['user_icode_open'] 	=	'on';	// user invide code for register



?>
