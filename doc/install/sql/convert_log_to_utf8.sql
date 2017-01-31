CREATE TABLE `leonardo_log_new` (
  `transactionID` bigint(20) unsigned NOT NULL auto_increment,
  `actionTime` bigint(20) unsigned NOT NULL default '0',
  `userID` mediumint(8) unsigned NOT NULL default '0',
  `effectiveUserID` mediumint(8) unsigned NOT NULL default '0',
  `ItemType` mediumint(8) unsigned NOT NULL default '0',
  `ItemID` mediumint(8) unsigned NOT NULL default '0',
  `ServerItemID` mediumint(8) unsigned NOT NULL default '0',
  `ActionID` mediumint(8) unsigned NOT NULL default '0',
  `ActionXML` text NOT NULL,
  `Modifier` mediumint(8) unsigned NOT NULL default '0',
  `ModifierID` mediumint(8) unsigned NOT NULL default '0',
  `ServerModifierID` mediumint(8) unsigned NOT NULL default '0',
  `Result` mediumint(8) unsigned NOT NULL default '0',
  `ResultDescription` text NOT NULL,
  PRIMARY KEY  (`transactionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

INSERT INTO `leonardo_log_new` SELECT * FROM `leonardo_log` ;

ALTER TABLE `leonardo_log` RENAME `leonardo_log_iso` ;

ALTER TABLE `leonardo_log_new` RENAME `leonardo_log` ;
