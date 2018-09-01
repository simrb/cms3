-- 
-- change the cms_db, cms_user, cms_pawd, as you want
--

CREATE database IF NOT EXISTS cms_db Character SET UTF8;
CREATE user 'cms_user'@'localhost' identified by 'cms_pawd';
grant all privileges on cms_db.* to cms_user@localhost identified by 'cms_pawd';
flush privileges;

use cms_db;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


--
-- ----------------------------------------
-- `record`, 
-- ----------------------------------------
--
CREATE TABLE `record` (
  `rid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `follow` int(11) NOT NULL default '0',
  `useful` int(5) NOT NULL default '0',
  `content` text NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY  (`rid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;
INSERT INTO `record` (`rid`, `uid`, `cid`, `follow`, `useful`, `content`, `created`) VALUES
(1, 1, 1, 0, 1, 'About the cms.\r\nThis is a cms created by php, we devote to simplicity, rudeness.', '1513346626'),
(2, 1, 1, 0, 1, 'About the user.', '1513346626'),
(3, 1, 1, 2, 1, 'About the post.\r\nAllow post 50 records for user everyday.', '1513346626'),
(4, 1, 1, 2, 1, 'About the comment.\r\nAllow post 50 comments for guest everyday.', '1513346626');


--
-- `recordkv`, for record, a key-val piece 
--
CREATE TABLE `recordkv` (
  `rkid` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL default '0',
  `rkey` varchar(50) NOT NULL,
  `rval` varchar(100) NOT NULL,
  PRIMARY KEY  (`rkid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `category`, for record
--
CREATE TABLE `category` (
  `cid` int(11) NOT NULL auto_increment,
  `follow` int(11) NOT NULL default '0',
  `number` tinyint(5) NOT NULL default '1',
  `name` varchar(20) NOT NULL,
  `descript` varchar(60),
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `category` (`cid`, `follow`, `number`, `name`, `descript`) VALUES
(1, 1, 1, 'home', ''),
(2, 1, 1, 'news', ''),
(3, 1, 1, 'show', '');


--
-- `file`, for record, upload image
--
CREATE TABLE `file` (
  `fid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL,
  `path` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `tag`, for record, like category
--
CREATE TABLE `tag` (
  `tid` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `tag_assoc`, for associating record and tag
--
CREATE TABLE `tag_assoc` (
  `taid` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY  (`taid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- ----------------------------------------
-- `optionkv`, for whole project, a key-val piece 
-- ----------------------------------------
--
CREATE TABLE `optionkv` (
  `oid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `okey` varchar(50) NOT NULL,
  `oval` varchar(100) NOT NULL,
  PRIMARY KEY  (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `optionkv` (`oid`, `uid`, `okey`, `oval`) VALUES
(1, 1, 'allow_comment', 'on'),
(2, 1, 'allow_register', 'on'),
(3, 1, 'last_post_ip', '127.0.0.1'),
(4, 1, 'last_post_time', '1'),
(5, 1, 'web_logo', 'logo.jpg'),
(6, 1, 'web_header', 'New site'),
(7, 1, 'web_title', 'New site'),
(8, 1, 'web_des', 'We devote to make a CMS as simplicity, rudeness.'),
(9, 1, 'web_kw', 'a cms'),
(10, 1, 'allow_guest_post_num', '50'),
(11, 1, 'allow_user_post_num', '50'),
(12, 1, 'allow_register_num', '50');


--
-- ----------------------------------------
-- `user`
-- ----------------------------------------
--
CREATE TABLE `user` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` tinyint(1) NOT NULL default '1',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- the password 8888 that md5 is cf79ae6addba60ad018347359bd144d2
INSERT INTO `user` (`uid`, `username`, `password`, `level`, `created`) VALUES
(1, 'simrbroot', '8888go', 9, '1513346626'),
(2, 'adminedit', '8888rb', 6, '1513346626'),
(3, 'frontedit', '8888py', 5, '1513346626'),
(4, 'frontuser', '8888js', 1, '1513346626');


--
-- `userkv`, for user, a key-val piece 
--
CREATE TABLE `userkv` (
  `ukid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `ukey` varchar(50) NOT NULL,
  `uval` varchar(100) NOT NULL,
  PRIMARY KEY  (`ukid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `sess`, for user,  session for marking the user login status
--
CREATE TABLE `sess` (
  `sid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `created` varchar(10) NOT NULL,
  `exptime` varchar(10) NOT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `usermsg`, for user,  keep saving the messages that has been send to user
--
CREATE TABLE `usermsg` (
  `umid` int(11) NOT NULL auto_increment,
  `fromuid` int(11) NOT NULL,
  `touid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `msg_type` tinyint(10) NOT NULL default '1',
  PRIMARY KEY  (`umid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



