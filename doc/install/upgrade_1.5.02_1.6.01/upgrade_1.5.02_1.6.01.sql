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
) ENGINE=MyISAM;



CREATE TABLE `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL,
  `flightID` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM;


ALTER TABLE `leonardo_clubs` ADD `areaID` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0';


ALTER TABLE `leonardo_pilots` ADD `countryCode` VARCHAR( 2 ) NOT NULL AFTER `pilotID` ;

ALTER TABLE `leonardo_maps` ADD INDEX ( `metersPerPixel` ) ;
ALTER TABLE `leonardo_maps` ADD INDEX ( `UTMzone` )  ;
ALTER TABLE `leonardo_maps` CHANGE `metersPerPixel` `metersPerPixel` FLOAT NOT NULL DEFAULT '0.00000'