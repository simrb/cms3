-- 
-- update the base schema
--

-- use cms_db;


-- DROP TABLE IF EXISTS `record_log`;
-- CREATE TABLE `record_log` (
CREATE TABLE IF NOT EXISTS `record_log` (
  `rlid` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL,
  `ukey` varchar(30) NOT NULL,
  `uval` varchar(50) NOT NULL,
  PRIMARY KEY  (`rlid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- modify field
--
ALTER TABLE `category` ADD `uid` INT(11) NOT NULL default '0';
ALTER TABLE `record_log` ADD `uid` INT(11) NOT NULL default '0';

ALTER TABLE `category` MODIFY COLUMN `name` VARCHAR(20);
ALTER TABLE `record_log` MODIFY COLUMN `ukey` VARCHAR(50);
ALTER TABLE `record_log` MODIFY COLUMN `uval` VARCHAR(100);
ALTER TABLE `user_log` MODIFY COLUMN `ukey` VARCHAR(50);
ALTER TABLE `user_log` MODIFY COLUMN `uval` VARCHAR(100);

