-- 
-- update the base schema
--

-- use cms_db;


-- DROP TABLE IF EXISTS `record_log`;


--
-- modify field
--
-- ALTER TABLE `category` ADD `uid` INT(11) NOT NULL default '0';
-- ALTER TABLE `category` MODIFY COLUMN `name` VARCHAR(20);


-- version v1.0.1 --> v1.0.2
--
-- `tag`, for record
--
-- DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS  `tag` (
  `tid` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- `tag_assoc`, for associating record and tag
--
-- DROP TABLE IF EXISTS `tag_assoc`;
CREATE TABLE IF NOT EXISTS  `tag_assoc` (
  `taid` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY  (`taid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- version v1.0.3 --> v1.0.3.1
--
-- `userkv`, for user, a key-val piece 
--
-- DROP TABLE IF EXISTS `userkv`;
CREATE TABLE IF NOT EXISTS `userkv` (
  `ukid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `ukey` varchar(50) NOT NULL,
  `uval` varchar(100) NOT NULL,
  PRIMARY KEY  (`ukid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `recordkv`;
CREATE TABLE IF NOT EXISTS `recordkv` (
  `rkid` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL default '0',
  `rkey` varchar(50) NOT NULL,
  `rval` varchar(100) NOT NULL,
  PRIMARY KEY  (`rkid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `category` CHANGE `uid` `descript` VARCHAR(60);

