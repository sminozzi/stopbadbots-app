DROP TABLE IF EXISTS `<DB_PREFIX>sbb_users`;
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>sbb_users` (
  `id` smallint(6) NOT NULL auto_increment,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `account_type` varchar(12) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `password_reset_token` VARCHAR(64) DEFAULT NULL,
  `password_reset_expiry` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

INSERT INTO `<DB_PREFIX>sbb_users` (`id`, `username`, `password`, `account_type`,`email`)
VALUES(1, '<USER_NAME>', <PASSWORD>, 'admin', '<EMAIL>');