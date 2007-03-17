
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
