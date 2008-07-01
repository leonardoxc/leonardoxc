
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



ALTER TABLE `leonardo_photos` CHANGE `name` `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `leonardo_photos` CHANGE `path` `path` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';



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


# 2007/07/17

ALTER TABLE `leonardo_servers` CHANGE `lastPullUpdateTm` `lastPullUpdateID` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `leonardo_flights` ADD `batchOpProcessed` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;

# 2007/07/18

CREATE TABLE `leonardo_photos` (
`ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`flightID` MEDIUMINT UNSIGNED NOT NULL ,
`path` VARCHAR( 255 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `ID` ) ,
INDEX ( `flightID` )
) TYPE = MYISAM ;

ALTER TABLE `leonardo_flights` ADD `hasPhotos` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `linkURL` ;

ALTER TABLE `leonardo_clubs_pilots` ADD `pilotServerID` MEDIUMINT UNSIGNED DEFAULT '0' NOT NULL ;

ALTER TABLE `leonardo_clubs_pilots` DROP PRIMARY KEY ;

ALTER TABLE `leonardo_clubs_pilots` ADD PRIMARY KEY ( `clubID` , `pilotID` , `pilotServerID` ) ;


# 2007/11/08
#  Changes by DHV 

ALTER TABLE leonardo_flights ADD NACid int(10) unsigned NOT NULL default '0' AFTER checkedBy;
ALTER TABLE leonardo_flights ADD INDEX NACClubIndex (NACclubID, NACid);

UPDATE leonardo_flights f  INNER JOIN leonardo_pilots p ON p.pilotID=f.userID
	SET f.NACid=p.NACid, f.NACclubID=p.NACclubID
	WHERE p.NACclubID>0 AND p.pilotID>0;

# The "newcomer" upgrade:
ALTER TABLE `leonardo_pilots` ADD `FirstOlcYear` INT( 10 ) NOT NULL DEFAULT '0' AFTER `PilotPhoto` ;


ALTER TABLE `leonardo_flights` ADD `originalKML` VARCHAR( 255 ) NOT NULL AFTER `originalURL` ;
ALTER TABLE `leonardo_servers` ADD `sync_format` VARCHAR( 20 ) DEFAULT 'XML' NOT NULL AFTER `lastPullUpdateID` ;


# 2007/11/16

#externalFlightType
#	0 -> local flight
#	1- > extllink  linked to external disply , only scoring info into DB
#	2 -> extflight IGC imported locally
#isLive  
#	0 -> not a live flight
#	1 -> in progress liveflight in progress, only basic info into db and link to actual display/server
#	2 -> finalized , liveflight finilized IGC imported locally
#
# forceBounds
#	1-> auto detect start/end
#	0-> set by user /admin

ALTER TABLE `leonardo_flights`
ADD `isLive` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `autoScore` ,
ADD `externalFlightType` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `isLive` ,
ADD `forceBounds` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `externalFlightType` ,
ADD `firstPointTM` INT UNSIGNED DEFAULT '0' NOT NULL AFTER `forceBounds` ,
ADD `firstLat` FLOAT NOT NULL AFTER `firstPointTM` ,
ADD `firstLon` FLOAT NOT NULL AFTER `firstLat` ,
ADD `lastPointTM` INT UNSIGNED DEFAULT '0' NOT NULL AFTER `firstLon` ,
ADD `lastLat` FLOAT NOT NULL AFTER `lastPointTM` ,
ADD `lastLon` FLOAT NOT NULL AFTER `lastLat` ;


# 2007/11/18

ALTER TABLE `leonardo_servers` ADD `sync_type` SMALLINT UNSIGNED NOT NULL DEFAULT '0' AFTER `sync_format` ,
ADD `use_zip` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `sync_type` ;


# 2007/12/03

ALTER TABLE `leonardo_pilots` ADD `BirthdateHideMask` VARCHAR( 10 ) DEFAULT 'xx.xx.xxxx' NOT NULL AFTER `Birthdate` ;


# 2007/12/12

CREATE TABLE `leonardo_remote_pilots` (
`remoteServerID` SMALLINT UNSIGNED NOT NULL DEFAULT '0',
`remoteUserID` BIGINT UNSIGNED NOT NULL DEFAULT '0',
`serverID` SMALLINT UNSIGNED NOT NULL DEFAULT '0',
`userID` BIGINT UNSIGNED NOT NULL DEFAULT '0'
) ENGINE = MYISAM ;


#2008/05/05 

ALTER TABLE `leonardo_areas` ADD `areaType` SMALLINT UNSIGNED DEFAULT '0' NOT NULL ,
ADD `min_lat` FLOAT DEFAULT '999' NOT NULL ,
ADD `max_lat` FLOAT DEFAULT '-999' NOT NULL ,
ADD `min_lon` FLOAT DEFAULT '999' NOT NULL ,
ADD `max_lon` FLOAT DEFAULT '-999' NOT NULL ,
ADD `center_lat` FLOAT DEFAULT '0' NOT NULL ,
ADD `center_lon` FLOAT DEFAULT '0' NOT NULL ,
ADD `radius` FLOAT DEFAULT '0' NOT NULL ,
ADD `polygon` TEXT NOT NULL ,
ADD `isInclusive` SMALLINT DEFAULT '1' NOT NULL ;

ALTER TABLE `leonardo_areas` ADD INDEX ( `areaType` ) ;


ALTER TABLE `leonardo_areas` CHANGE `areaID` `areaID` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_areas` CHANGE `areaID` `ID` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `leonardo_areas` CHANGE `ID` `ID` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT ;


CREATE TABLE `leonardo_flights_score` (
`ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`flightID` BIGINT UNSIGNED NOT NULL ,
`method` TINYINT UNSIGNED NOT NULL ,
`type` TINYINT UNSIGNED NOT NULL ,
`isBest` BOOL NOT NULL ,
`distance` FLOAT NOT NULL ,
`score` FLOAT NOT NULL ,
`turnpoint1` VARCHAR( 50 ) NOT NULL ,
`turnpoint2` VARCHAR( 50 ) NOT NULL ,
`turnpoint3` VARCHAR( 50 ) NOT NULL ,
`turnpoint4` VARCHAR( 50 ) NOT NULL ,
`turnpoint5` VARCHAR( 50 ) NOT NULL ,
`turnpoint6` VARCHAR( 50 ) NOT NULL ,
`turnpoint7` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `ID` ) ,
INDEX ( `flightID` , `method` , `type` , `isBest` )
) TYPE = MYISAM ;


# ALTER TABLE `leonardo_photos` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;


# 2008/05/22

ALTER TABLE `leonardo_flights` DROP INDEX `takeoffID_2`  ;


#2008/05/27

ALTER TABLE `leonardo_servers` DROP `isLeo` ,
DROP `installation_type` ,
DROP `leonardo_version` ,
DROP `url` ,
DROP `url_base` ,
DROP `url_op` ,
DROP `admin_email` ,
DROP `site_pass` ,
DROP `serverPass` ,
DROP `clientPass` ,
DROP `sync_format` ,
DROP `sync_type` ,
DROP `use_zip` ,
DROP `is_active` ,
DROP `gives_waypoints` ,
DROP `waypoint_countries` ;


ALTER TABLE `leonardo_flights` ADD `excludeFrom` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `active` ;


# 2008/06/09

ALTER TABLE `leonardo_flights` ADD `dateUpdated` DATETIME NOT NULL AFTER `dateAdded` ;

UPDATE `leonardo_flights` SET dateUpdated=dateAdded;


#2008/07/01
ALTER TABLE `leonardo_remote_pilots` ADD PRIMARY KEY ( `remoteServerID` , `remoteUserID` , `serverID` , `userID` );
