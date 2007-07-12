
ALTER TABLE `leonardo_flights` ADD INDEX ( `takeoffID` ) ;
ALTER TABLE `leonardo_flights` ADD `grecord` SMALLINT NOT NULL , ADD `validated` SMALLINT NOT NULL ;
ALTER TABLE `leonardo_flights` CHANGE `grecord` `grecord` SMALLINT( 6 ) NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_flights` CHANGE `validated` `validated` SMALLINT( 6 ) NOT NULL DEFAULT '0';



CREATE TABLE `leonardo_stats` (
  `tm` bigint(20) unsigned NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `month` tinyint(3) unsigned NOT NULL,
  `day` tinyint(3) unsigned NOT NULL,
  `userID` bigint(20) unsigned NOT NULL,
  `sessionID` bigint(20) unsigned NOT NULL,
  `visitorID` bigint(20) unsigned NOT NULL,
  `op` char(25) NOT NULL default '',
  `flightID` bigint(20) unsigned NOT NULL,
  `executionTime` float unsigned NOT NULL,
  `os` char(20) NOT NULL default '',
  `browser` char(15) NOT NULL default '',
  `browser_version` char(10) NOT NULL default '',
  KEY `tm` (`tm`,`year`,`month`,`day`)
) ENGINE=MyISAM ;


ALTER TABLE `leonardo_flights` ADD `category` SMALLINT UNSIGNED NOT NULL DEFAULT '2' AFTER `subcat` ;
ALTER TABLE `leonardo_flights` ADD `validationMessage` TEXT NOT NULL AFTER `validated` ;




ALTER TABLE `leonardo_pilots` ADD `NACid` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `countryCode` ,
ADD `NACmemberID` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `NACid` ;


# 2007/03/07

CREATE TABLE `leonardo_NAC_clubs` (
`NAC_ID` MEDIUMINT NOT NULL ,
`clubID` BIGINT NOT NULL ,
`clubName` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `NAC_ID` , `clubID` )
) ENGINE = MYISAM ;


ALTER TABLE `leonardo_pilots` ADD `NACclubID` BIGINT NOT NULL AFTER `NACmemberID` ;

ALTER TABLE `leonardo_flights` ADD `NACclubID` BIGINT NOT NULL ;

ALTER TABLE `leonardo_pilots` CHANGE `sponsorID` `sponsor` VARCHAR( 255 ) NULL ;


# 2007/03/16

ALTER TABLE `leonardo_flights` ADD `autoScore` FLOAT NOT NULL DEFAULT '0' AFTER `FLIGHT_POINTS` ;


# 2007/04/06

CREATE TABLE `leonardo_airspace` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL,
  `serial` tinyint(4) NOT NULL default '0',
  `disabled` tinyint(4) NOT NULL default '0',
  `updated` tinyint(4) NOT NULL default '0',
  `Type` varchar(30) NOT NULL,
  `Shape` tinyint(3) unsigned NOT NULL default '0',
  `Comments` varchar(255) NOT NULL,
  `minx` float NOT NULL,
  `miny` float NOT NULL,
  `maxx` float NOT NULL,
  `maxy` float NOT NULL,
  `Base` blob NOT NULL,
  `Top` blob NOT NULL,
  `Points` mediumblob NOT NULL,
  `Radius` float NOT NULL,
  `Latitude` float NOT NULL,
  `Longitude` float NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`,`serial`),
  KEY `minx` (`minx`,`miny`,`maxx`,`maxy`),
  KEY `serial` (`serial`,`disabled`),
  KEY `serial_2` (`serial`,`disabled`)
) TYPE =MyISAM ;

ALTER TABLE `leonardo_flights` ADD `airspaceCheck` TINYINT DEFAULT '0' NOT NULL AFTER `validationMessage` ,
ADD `airspaceCheckFinal` TINYINT DEFAULT '0' NOT NULL AFTER `airspaceCheck` ,
ADD `airspaceCheckMsg` TEXT NOT NULL AFTER `airspaceCheckFinal` ,
ADD `checkedBy` VARCHAR( 100 ) NOT NULL AFTER `airspaceCheckMsg` ;

# 2007/04/19

ALTER TABLE `leonardo_waypoints` ADD INDEX ( `lat` , `lon` ) ;


# 2007/07/09

ALTER TABLE `leonardo_flights` ADD `hash` VARCHAR( 100 ) NOT NULL ;


# 2007/07/10

ALTER TABLE `leonardo_flights` ADD `serverID` SMALLINT UNSIGNED DEFAULT '0' NOT NULL AFTER `ID` ,
ADD `originalURL` VARCHAR( 255 ) NOT NULL AFTER `serverID` ,
ADD `original_ID` MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER `originalURL` ;

ALTER TABLE `leonardo_flights` ADD `originalUserID` MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER `userID` ;
ALTER TABLE `leonardo_flights` ADD `userServerID` MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER `originalUserID` ;

ALTER TABLE `leonardo_pilots` ADD `serverID` SMALLINT UNSIGNED DEFAULT '0' NOT NULL AFTER `pilotID` ;

ALTER TABLE `leonardo_pilots` DROP PRIMARY KEY , ADD PRIMARY KEY ( `pilotID` , `serverID` ) ;

ALTER TABLE `leonardo_pilots` ADD `CIVL_ID` MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL AFTER `countryCode` ;


ALTER TABLE `leonardo_servers` ADD `serverPass` VARCHAR( 50 ) NOT NULL AFTER `site_pass` ,
ADD `clientPass` VARCHAR( 50 ) NOT NULL AFTER `serverPass` ,
ADD `lastPullUpdateTm` BIGINT UNSIGNED DEFAULT '0' NOT NULL AFTER `clientPass` ;


