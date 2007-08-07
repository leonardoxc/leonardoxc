CREATE TABLE `leonardo_areas` (
  `areaID` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `descInt` varchar(255) NOT NULL,
  PRIMARY KEY  (`areaID`)
) ENGINE=MyISAM ;


CREATE TABLE `leonardo_areas_takeoffs` (
  `areaID` mediumint(8) unsigned NOT NULL,
  `takeoffID` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM ;


CREATE TABLE `leonardo_clubs` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `intName` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `intDescription` text NOT NULL,
  `cat` smallint(5) unsigned NOT NULL default '1',
  `location` varchar(60) NOT NULL default '',
  `intLocation` varchar(60) NOT NULL default '',
  `countryCode` varchar(30) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `club_admin` bigint(20) unsigned NOT NULL default '0',
  `contact_person` varchar(255) NOT NULL default '',
  `formula` smallint(6) NOT NULL default '0',
  `formula_parameters` text NOT NULL,
  `areaID` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM ;


CREATE TABLE `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL,
  `flightID` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM ;

CREATE TABLE `leonardo_clubs_pilots` (
  `clubID` bigint(20) unsigned NOT NULL default '0',
  `pilotID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clubID`,`pilotID`)
) ENGINE=MyISAM ;


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
) ENGINE=MyISAM ;


CREATE TABLE `leonardo_servers` (
  `ID` mediumint(8) unsigned NOT NULL auto_increment,
  `isLeo` tinyint(3) unsigned NOT NULL,
  `installation_type` smallint(5) unsigned NOT NULL default '2',
  `leonardo_version` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_base` varchar(255) NOT NULL,
  `url_op` varchar(255) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `site_pass` varchar(100) NOT NULL,
  `is_active` tinyint(3) unsigned NOT NULL default '0',
  `gives_waypoints` tinyint(3) unsigned NOT NULL default '0',
  `waypoint_countries` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM ;


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

ALTER TABLE `leonardo_flights` MODIFY COLUMN `userID` MEDIUMINT(8) NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_flights` ADD COLUMN `category` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '2';
ALTER TABLE `leonardo_flights` ADD COLUMN `gliderBrandID` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_flights` ADD COLUMN `photo4Filename` VARCHAR(150) NOT NULL;
ALTER TABLE `leonardo_flights` ADD COLUMN `photo5Filename` VARCHAR(150) NOT NULL;
ALTER TABLE `leonardo_flights` ADD COLUMN `photo6Filename` VARCHAR(150) NOT NULL;
ALTER TABLE `leonardo_flights` ADD COLUMN `grecord` SMALLINT(6) NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_flights` ADD COLUMN `validated` SMALLINT(6) NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_flights` ADD COLUMN `validationMessage` TEXT NOT NULL;
ALTER TABLE `leonardo_pilots` ADD COLUMN `countryCode` CHAR(2) NOT NULL;
ALTER TABLE `leonardo_pilots` ADD COLUMN `NACid` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_pilots` ADD COLUMN `NACmemberID` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_waypoints` MODIFY COLUMN `description` TEXT NOT NULL;
ALTER TABLE `leonardo_waypoints` MODIFY COLUMN `modifyDate` DATE NOT NULL DEFAULT '2005-09-01';
ALTER TABLE `leonardo_flights` ADD KEY `takeoffID` (`takeoffID`);

