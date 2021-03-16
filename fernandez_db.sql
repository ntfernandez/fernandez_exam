/*
MySQL Backup
Source Server Version: 5.7.24
Source Database: fernandez_db
Date: 3/16/2021 20:15:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `tbl_article`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_article`;
CREATE TABLE `tbl_article` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_title` varchar(255) DEFAULT NULL,
  `art_content` text,
  `is_publish` int(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `art_url` text,
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `tbl_article` VALUES ('1','Art I','art test','0','2021-03-16 09:48:37','2021-03-16 12:05:58','1-art-i');
