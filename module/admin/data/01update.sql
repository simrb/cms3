-- 
-- update the base schema
--

-- use cms_db;


DROP TABLE IF EXISTS `record_log`;


--
-- modify field
--
ALTER TABLE `category` ADD `uid` INT(11) NOT NULL default '0';
ALTER TABLE `category` MODIFY COLUMN `name` VARCHAR(20);



--
-- `wption`, the alias of option
--
CREATE TABLE `wption` (
  `wpid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `wkey` varchar(50) NOT NULL,
  `wval` varchar(100) NOT NULL,
  PRIMARY KEY  (`wpid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `wption` (`wpid`, `uid`, `wkey`, `wval`) VALUES
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



CREATE TABLE IF NOT EXISTS `sess` (
  `sid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `exptime` varchar(20) NOT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
