DROP TABLE IF EXISTS `<DB_PREFIX>sbb_users`;
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>sbb_users` (
  `id` smallint(6) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `account_type` varchar(12) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `<DB_PREFIX>sbb_users` (`id`, `username`, `password`, `account_type`,`email`)
VALUES(1, '<USER_NAME>', <PASSWORD>, 'admin', '<EMAIL>');

