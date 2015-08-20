SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `access` tinyint(1) unsigned NOT NULL COMMENT '0=guest, 1=member, 2=admin',
  `created` int(10) unsigned NOT NULL,
  `last` int(10) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` varchar(10) NOT NULL COMMENT 'DD/MM/YYYY',
  `birthplace` varchar(255) NOT NULL,
  `address` varchar(512) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`,`password`),
  KEY `full_name` (`full_name`),
  KEY `email` (`email`),
  KEY `sin` (`sin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='2' AUTO_INCREMENT=4 ;
