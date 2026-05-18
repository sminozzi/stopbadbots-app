
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>test` (
  `id` smallint(6) NOT NULL auto_increment,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `account_type` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `<DB_PREFIX>test` ADD `date_created` DATETIME NULL DEFAULT NULL;