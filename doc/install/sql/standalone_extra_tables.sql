-- --------------------------------------------------------
-- LEONARDO-STANDALONE.sql --
-- --------------------------------------------------------


CREATE TABLE `leonardo_sessions` (
`session_id` char(32) NOT NULL,
`session_user_id` mediumint(9) NOT NULL,
`session_start` int(11) NOT NULL,
`session_time` int(11) NOT NULL,
`session_ip` char(8) NOT NULL,
`session_page` int(11) NOT NULL,
`session_logged_in` tinyint(4) NOT NULL,
`session_admin` tinyint(4) NOT NULL,
PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_users`
-- 

CREATE TABLE `leonardo_users` (
`user_id` mediumint(8) NOT NULL auto_increment,
`user_active` tinyint(1) default '1',
`username` varchar(25) NOT NULL,
`user_password` varchar(32) NOT NULL,
`user_session_time` int(11) NOT NULL default '0',
`user_session_page` smallint(5) NOT NULL default '0',
`user_lastvisit` int(11) NOT NULL default '0',
`user_regdate` int(11) NOT NULL default '0',
`user_level` tinyint(4) default '0',
`user_posts` mediumint(8) unsigned NOT NULL default '0',
`user_timezone` decimal(5,2) NOT NULL default '0.00',
`user_style` tinyint(4) default NULL,
`user_lang` varchar(255) default NULL,
`user_dateformat` varchar(14) NOT NULL default 'd M Y H:i',
`user_new_privmsg` smallint(5) unsigned NOT NULL default '0',
`user_unread_privmsg` smallint(5) unsigned NOT NULL default '0',
`user_last_privmsg` int(11) NOT NULL default '0',
`user_login_tries` smallint(5) unsigned NOT NULL default '0',
`user_last_login_try` int(11) NOT NULL default '0',
`user_emailtime` int(11) default NULL,
`user_viewemail` tinyint(1) default NULL,
`user_attachsig` tinyint(1) default NULL,
`user_allowhtml` tinyint(1) default '1',
`user_allowbbcode` tinyint(1) default '1',
`user_allowsmile` tinyint(1) default '1',
`user_allowavatar` tinyint(1) NOT NULL default '1',
`user_allow_pm` tinyint(1) NOT NULL default '1',
`user_allow_viewonline` tinyint(1) NOT NULL default '1',
`user_notify` tinyint(1) NOT NULL default '1',
`user_notify_pm` tinyint(1) NOT NULL default '0',
`user_popup_pm` tinyint(1) NOT NULL default '0',
`user_rank` int(11) default '0',
`user_avatar` varchar(100) default NULL,
`user_avatar_type` tinyint(4) NOT NULL default '0',
`user_email` varchar(255) default NULL,
`user_icq` varchar(15) default NULL,
`user_website` varchar(100) default NULL,
`user_from` varchar(100) default NULL,
`user_sig` text,
`user_sig_bbcode_uid` char(10) default NULL,
`user_aim` varchar(255) default NULL,
`user_yim` varchar(255) default NULL,
`user_msnm` varchar(255) default NULL,
`user_occ` varchar(100) default NULL,
`user_interests` varchar(255) default NULL,
`user_actkey` varchar(32) default NULL,
`user_newpasswd` varchar(32) default NULL,
PRIMARY KEY (`user_id`),
KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `leonardo_temp_users` (
  `user_id` mediumint(8) NOT NULL auto_increment,
  `user_civlid` int(6) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_firstname` varchar(25) NOT NULL,
  `user_lastname` varchar(25) NOT NULL,
  `user_nickname` varchar(25) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_nation` varchar(5) NOT NULL,
  `user_gender` varchar(5) NOT NULL,
  `user_birthdate` int(8) NOT NULL,
  `user_session_time` int(11) NOT NULL default '0',
  `user_regdate` int(11) NOT NULL default '0',
  `user_email` varchar(255) default NULL,
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(32) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



