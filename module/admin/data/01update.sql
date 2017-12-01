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

CREATE TABLE IF NOT EXISTS `sess` (
  `sid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `exptime` varchar(20) NOT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
