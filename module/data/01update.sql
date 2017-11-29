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
ALTER TABLE `user_log` MODIFY COLUMN `ukey` VARCHAR(50);
ALTER TABLE `user_log` MODIFY COLUMN `uval` VARCHAR(100);

