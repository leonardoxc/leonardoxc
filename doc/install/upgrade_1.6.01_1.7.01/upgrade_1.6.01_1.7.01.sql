

ALTER TABLE `leonardo_flights` ADD `photo4Filename` VARCHAR( 150 ) NOT NULL AFTER `photo3Filename` ,
ADD `photo5Filename` VARCHAR( 150 ) NOT NULL AFTER `photo4Filename` ,
ADD `photo6Filename` VARCHAR( 150 ) NOT NULL AFTER `photo5Filename` ;



CREATE TABLE `leonardo_servers` (
`ID` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`isLeo` TINYINT UNSIGNED NOT NULL ,
`type` SMALLINT UNSIGNED NOT NULL ,
`url_base` VARCHAR( 255 ) NOT NULL ,
`url_op` VARCHAR( 255 ) NOT NULL ,
`admin_email` VARCHAR( 100 ) NOT NULL ,
`site_pass` VARCHAR( 100 ) NOT NULL ,
`is_active` TINYINT UNSIGNED DEFAULT '0' NOT NULL ,
`gives_waypoints` TINYINT UNSIGNED DEFAULT '0' NOT NULL ,
`waypoint_countries` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `ID` )
) TYPE = MYISAM ;

ALTER TABLE `leonardo_servers` ADD `leonardo_version` VARCHAR( 20 ) NOT NULL AFTER `type` ;

ALTER TABLE `leonardo_servers` CHANGE `type` `installation_type` SMALLINT UNSIGNED NOT NULL DEFAULT '2';

ALTER TABLE `leonardo_servers` ADD `url` VARCHAR( 255 ) NOT NULL AFTER `leonardo_version` ;


CREATE TABLE `leonardo_log` (
  `transactionID` bigint(20) unsigned NOT NULL auto_increment,
  `actionTime` bigint(20) unsigned NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  `effectiveUserID` mediumint(8) unsigned NOT NULL,
  `ItemType` mediumint(8) unsigned NOT NULL,
  `ItemID` mediumint(8) unsigned NOT NULL,
  `ServerItemID` mediumint(8) unsigned NOT NULL,
  `ActionID` mediumint(8) unsigned NOT NULL,
  `ActionXML` text NOT NULL,
  `Modifier` mediumint(8) unsigned NOT NULL,
  `ModifierID` mediumint(8) unsigned NOT NULL,
  `ServerModifierID` mediumint(8) unsigned NOT NULL,
  `Result` mediumint(8) unsigned NOT NULL,
  `ResultDescription` text NOT NULL,
  PRIMARY KEY  (`transactionID`)
) TYPE=MyISAM   ;
