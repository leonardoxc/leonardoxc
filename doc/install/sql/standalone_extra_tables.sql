-- --------------------------------------------------------
-- LEONARDO-STANDALONE.sql --
-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_sessions`
-- 

DROP TABLE IF EXISTS `leonardo_sessions`;
CREATE TABLE `leonardo_sessions` (
  `session_id` char(32) NOT NULL,
  `session_user_id` mediumint(9) NOT NULL,
  `session_start` int(11) NOT NULL,
  `session_time` int(11) NOT NULL,
  `session_ip` char(8) NOT NULL,
  `session_page` int(11) NOT NULL,
  `session_logged_in` tinyint(4) NOT NULL,
  `session_admin` tinyint(4) NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_users`
-- 

DROP TABLE IF EXISTS `leonardo_users`;
CREATE TABLE `leonardo_users` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_active` tinyint(1) default '1',
  `username` varchar(25) NOT NULL,
  `user_civlid` varchar(10) NOT NULL,
  `user_password` varchar(34) NOT NULL,
  `user_session_time` int(11) NOT NULL default '0',
  `user_session_page` smallint(5) NOT NULL default '0',
  `user_lastvisit` int(11) NOT NULL default '0',
  `user_regdate` int(11) NOT NULL default '0',
  `user_level` tinyint(4) NOT NULL default '0',
  `user_login_tries` smallint(5) unsigned NOT NULL default '0',
  `user_last_login_try` int(11) NOT NULL default '0',
  `user_emailtime` int(11) default NULL,
  `user_viewemail` tinyint(1) default NULL,
  `user_email` varchar(255) default NULL,
  `user_new_email` varchar(255) NOT NULL,
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(34) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0;


-- 
-- Table structure for table `leonardo_temp_users`
-- 

DROP TABLE IF EXISTS `leonardo_temp_users`;
CREATE TABLE `leonardo_temp_users` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_civlid` int(6) NOT NULL,
  `user_civlname` varchar(150) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_firstname` varchar(25) NOT NULL,
  `user_lastname` varchar(25) NOT NULL,
  `user_nickname` varchar(25) NOT NULL,
  `user_password` varchar(34) NOT NULL,
  `user_nation` varchar(5) NOT NULL,
  `user_gender` varchar(5) NOT NULL,
  `user_birthdate` varchar(15) NOT NULL,
  `user_session_time` int(11) NOT NULL default '0',
  `user_regdate` int(11) NOT NULL default '0',
  `user_email` varchar(255) default NULL,
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(34) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

