-- phpMyAdmin SQL Dump
-- version 2.6.4-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: thales.thenet.gr
-- Generation Time: Dec 03, 2007 at 03:16 PM
-- Server version: 5.0.22
-- PHP Version: 4.1.2
-- 
-- Database: `paraglidingforum2`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_NAC_clubs`
-- 

CREATE TABLE `leonardo_NAC_clubs` (
  `NAC_ID` mediumint(9) NOT NULL default '0',
  `clubID` bigint(20) NOT NULL default '0',
  `clubName` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`NAC_ID`,`clubID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_airspace`
-- 

CREATE TABLE `leonardo_airspace` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL default '',
  `serial` tinyint(4) NOT NULL default '0',
  `disabled` tinyint(4) NOT NULL default '0',
  `updated` tinyint(4) NOT NULL default '0',
  `Type` varchar(30) NOT NULL default '',
  `Shape` tinyint(3) unsigned NOT NULL default '0',
  `Comments` varchar(255) NOT NULL default '',
  `minx` float NOT NULL default '0',
  `miny` float NOT NULL default '0',
  `maxx` float NOT NULL default '0',
  `maxy` float NOT NULL default '0',
  `Base` blob NOT NULL,
  `Top` blob NOT NULL,
  `Points` mediumblob NOT NULL,
  `Radius` float NOT NULL default '0',
  `Latitude` float NOT NULL default '0',
  `Longitude` float NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`,`serial`),
  KEY `minx` (`minx`,`miny`,`maxx`,`maxy`),
  KEY `serial` (`serial`,`disabled`),
  KEY `serial_2` (`serial`,`disabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_areas`
-- 

CREATE TABLE `leonardo_areas` (
  `areaID` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  `descInt` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`areaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_areas_takeoffs`
-- 

CREATE TABLE `leonardo_areas_takeoffs` (
  `areaID` mediumint(8) unsigned NOT NULL default '0',
  `takeoffID` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs_flights`
-- 

CREATE TABLE `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL default '0',
  `flightID` mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs_pilots`
-- 

CREATE TABLE `leonardo_clubs_pilots` (
  `clubID` bigint(20) unsigned NOT NULL default '0',
  `pilotID` bigint(20) unsigned NOT NULL default '0',
  `pilotServerID` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clubID`,`pilotID`,`pilotServerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_flights`
-- 

CREATE TABLE `leonardo_flights` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `originalURL` varchar(255) NOT NULL,
  `originalKML` varchar(255) NOT NULL,
  `original_ID` mediumint(8) unsigned NOT NULL default '0',
  `cat` smallint(5) unsigned NOT NULL default '1',
  `subcat` smallint(5) unsigned NOT NULL default '1',
  `category` smallint(5) unsigned NOT NULL default '2',
  `active` smallint(6) NOT NULL default '0',
  `dateAdded` datetime NOT NULL default '0000-00-00 00:00:00',
  `timesViewed` mediumint(9) NOT NULL default '0',
  `userID` bigint(20) NOT NULL default '0',
  `originalUserID` mediumint(8) unsigned NOT NULL default '0',
  `userServerID` mediumint(8) unsigned NOT NULL default '0',
  `filename` varchar(200) NOT NULL default '',
  `place` varchar(100) NOT NULL default '',
  `glider` varchar(50) NOT NULL default '',
  `gliderBrandID` smallint(5) unsigned NOT NULL default '0',
  `comments` text NOT NULL,
  `linkURL` varchar(200) NOT NULL default '',
  `hasPhotos` tinyint(3) unsigned NOT NULL default '0',
  `photo1Filename` varchar(150) NOT NULL default '',
  `photo2Filename` varchar(150) NOT NULL default '',
  `photo3Filename` varchar(150) NOT NULL default '',
  `photo4Filename` varchar(150) NOT NULL default '',
  `photo5Filename` varchar(150) NOT NULL default '',
  `photo6Filename` varchar(150) NOT NULL default '',
  `takeoffID` mediumint(9) NOT NULL default '0',
  `takeoffVinicity` float NOT NULL default '0',
  `landingID` mediumint(9) NOT NULL default '0',
  `landingVinicity` float NOT NULL default '0',
  `DATE` date NOT NULL default '0000-00-00',
  `timezone` float NOT NULL default '0',
  `MAX_SPEED` float NOT NULL default '0',
  `MEAN_SPEED` float NOT NULL default '0',
  `MAX_ALT` int(11) NOT NULL default '0',
  `MIN_ALT` int(11) NOT NULL default '0',
  `TAKEOFF_ALT` int(11) NOT NULL default '0',
  `MAX_VARIO` float NOT NULL default '0',
  `MIN_VARIO` float NOT NULL default '0',
  `LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `MAX_LINEAR_DISTANCE` bigint(20) NOT NULL default '0',
  `START_TIME` mediumint(9) NOT NULL default '0',
  `END_TIME` mediumint(9) NOT NULL default '0',
  `DURATION` mediumint(9) NOT NULL default '0',
  `BEST_FLIGHT_TYPE` varchar(30) NOT NULL default '',
  `FLIGHT_KM` float NOT NULL default '0',
  `FLIGHT_POINTS` float NOT NULL default '0',
  `autoScore` float NOT NULL default '0',
  `isLive` tinyint(3) unsigned NOT NULL default '0',
  `externalFlightType` tinyint(3) unsigned NOT NULL default '0',
  `forceBounds` tinyint(3) unsigned NOT NULL default '0',
  `firstPointTM` int(10) unsigned NOT NULL default '0',
  `firstLat` float NOT NULL,
  `firstLon` float NOT NULL,
  `lastPointTM` int(10) unsigned NOT NULL default '0',
  `lastLat` float NOT NULL,
  `lastLon` float NOT NULL,
  `FIRST_POINT` varchar(50) NOT NULL default '',
  `LAST_POINT` varchar(50) NOT NULL default '',
  `turnpoint1` varchar(100) NOT NULL default '',
  `turnpoint2` varchar(100) NOT NULL default '',
  `turnpoint3` varchar(100) NOT NULL default '',
  `turnpoint4` varchar(100) NOT NULL default '',
  `turnpoint5` varchar(100) NOT NULL default '',
  `olcRefNum` varchar(30) NOT NULL default '',
  `olcFilename` varchar(12) NOT NULL default '',
  `olcDateSubmited` datetime NOT NULL default '0000-00-00 00:00:00',
  `private` tinyint(3) unsigned NOT NULL default '0',
  `gpsTrack` tinyint(3) unsigned NOT NULL default '1',
  `grecord` smallint(6) NOT NULL default '0',
  `validated` smallint(6) NOT NULL default '0',
  `validationMessage` text NOT NULL,
  `airspaceCheck` tinyint(4) NOT NULL default '0',
  `airspaceCheckFinal` tinyint(4) NOT NULL default '0',
  `airspaceCheckMsg` text NOT NULL,
  `checkedBy` varchar(100) NOT NULL default '',
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACclubID` bigint(20) NOT NULL default '0',
  `hash` varchar(100) NOT NULL,
  `batchOpProcessed` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `userID` (`userID`),
  KEY `takeoffID` (`takeoffID`),
  KEY `NACClubIndex` (`NACclubID`,`NACid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_log`
-- 

CREATE TABLE `leonardo_log` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_maps`
-- 

CREATE TABLE `leonardo_maps` (
  `ID` bigint(20) NOT NULL auto_increment,
  `filename` varchar(200) NOT NULL default '',
  `leftX` double(10,2) NOT NULL default '0.00',
  `topY` double(10,2) NOT NULL default '0.00',
  `rightX` double(10,2) NOT NULL default '0.00',
  `bottomY` double(10,2) NOT NULL default '0.00',
  `UTMzone` smallint(6) NOT NULL default '0',
  `pixelWidth` mediumint(9) NOT NULL default '0',
  `pixelHeight` mediumint(9) NOT NULL default '0',
  `metersPerPixel` float(7,5) NOT NULL default '0.00000',
  PRIMARY KEY  (`ID`,`filename`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_photos`
-- 

CREATE TABLE `leonardo_photos` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `flightID` mediumint(8) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `flightID` (`flightID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_pilots`
-- 

CREATE TABLE `leonardo_pilots` (
  `pilotID` bigint(20) NOT NULL default '0',
  `serverID` smallint(5) unsigned NOT NULL default '0',
  `countryCode` char(2) NOT NULL default '',
  `CIVL_ID` mediumint(8) unsigned NOT NULL default '0',
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACmemberID` bigint(20) unsigned NOT NULL default '0',
  `NACclubID` bigint(20) NOT NULL default '0',
  `olcBirthDate` varchar(8) NOT NULL default '',
  `olcFirstName` varchar(100) NOT NULL default '',
  `olcLastName` varchar(100) NOT NULL default '',
  `olcCallSign` varchar(50) NOT NULL default '',
  `olcFilenameSuffix` varchar(4) NOT NULL default '',
  `olcAutoSubmit` tinyint(4) NOT NULL default '0',
  `FirstName` varchar(40) NOT NULL default '',
  `LastName` varchar(50) NOT NULL default '',
  `clubID` mediumint(8) unsigned NOT NULL default '0',
  `sponsor` varchar(255) NOT NULL default '',
  `Sex` varchar(6) NOT NULL default '',
  `Birthdate` varchar(15) NOT NULL default '',
  `BirthdateHideMask` varchar(10) NOT NULL default 'xx.xx.xxxx',
  `Occupation` varchar(100) NOT NULL default '',
  `MartialStatus` varchar(20) NOT NULL default '',
  `OtherInterests` longtext NOT NULL,
  `PersonalWebPage` varchar(150) NOT NULL default '',
  `PilotLicence` varchar(100) NOT NULL default '',
  `BestMemory` longtext NOT NULL,
  `WorstMemory` longtext NOT NULL,
  `Training` varchar(200) NOT NULL default '',
  `personalDistance` varchar(150) NOT NULL default '',
  `personalHeight` varchar(150) NOT NULL default '',
  `glider` varchar(200) NOT NULL default '',
  `FlyingSince` varchar(100) NOT NULL default '',
  `HoursFlown` varchar(50) NOT NULL default '',
  `HoursPerYear` varchar(50) NOT NULL default '',
  `FavoriteLocation` varchar(250) NOT NULL default '',
  `UsualLocation` varchar(150) NOT NULL default '',
  `FavoriteBooks` varchar(150) NOT NULL default '',
  `FavoriteActors` varchar(150) NOT NULL default '',
  `FavoriteSingers` varchar(150) NOT NULL default '',
  `FavoriteMovies` varchar(150) NOT NULL default '',
  `FavoriteSite` varchar(150) NOT NULL default '',
  `Sign` varchar(40) NOT NULL default '',
  `Spiral` varchar(60) NOT NULL default '',
  `Bline` varchar(100) NOT NULL default '',
  `FullStall` varchar(100) NOT NULL default '',
  `Sat` varchar(100) NOT NULL default '',
  `AsymmetricSpiral` varchar(100) NOT NULL default '',
  `Spin` varchar(100) NOT NULL default '',
  `OtherAcro` varchar(150) NOT NULL default '',
  `camera` varchar(150) NOT NULL default '',
  `camcorder` varchar(150) NOT NULL default '',
  `Vario` varchar(60) NOT NULL default '',
  `GPS` varchar(60) NOT NULL default '',
  `Harness` varchar(60) NOT NULL default '',
  `Reserve` varchar(60) NOT NULL default '',
  `Helmet` varchar(60) NOT NULL default '',
  `PilotPhoto` varchar(30) NOT NULL default '',
  `FirstOlcYear` int(10) NOT NULL default '0',
  PRIMARY KEY  (`pilotID`,`serverID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_servers`
-- 

CREATE TABLE `leonardo_servers` (
  `ID` mediumint(8) unsigned NOT NULL auto_increment,
  `isLeo` tinyint(3) unsigned NOT NULL default '0',
  `installation_type` smallint(5) unsigned NOT NULL default '2',
  `leonardo_version` varchar(20) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `url_base` varchar(255) NOT NULL default '',
  `url_op` varchar(255) NOT NULL default '',
  `admin_email` varchar(100) NOT NULL default '',
  `site_pass` varchar(100) NOT NULL default '',
  `serverPass` varchar(50) NOT NULL,
  `clientPass` varchar(50) NOT NULL,
  `lastPullUpdateID` bigint(20) unsigned NOT NULL default '0',
  `sync_format` varchar(20) NOT NULL default 'XML',
  `sync_type` smallint(5) unsigned NOT NULL default '0',
  `use_zip` tinyint(3) unsigned NOT NULL default '0',
  `is_active` tinyint(3) unsigned NOT NULL default '0',
  `gives_waypoints` tinyint(3) unsigned NOT NULL default '0',
  `waypoint_countries` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_stats`
-- 

CREATE TABLE `leonardo_stats` (
  `tm` bigint(20) unsigned NOT NULL default '0',
  `year` smallint(5) unsigned NOT NULL default '0',
  `month` tinyint(3) unsigned NOT NULL default '0',
  `day` tinyint(3) unsigned NOT NULL default '0',
  `userID` bigint(20) unsigned NOT NULL default '0',
  `sessionID` bigint(20) unsigned NOT NULL default '0',
  `visitorID` bigint(20) unsigned NOT NULL default '0',
  `op` char(25) NOT NULL default '',
  `flightID` bigint(20) unsigned NOT NULL default '0',
  `executionTime` float unsigned NOT NULL default '0',
  `os` char(20) NOT NULL default '',
  `browser` char(15) NOT NULL default '',
  `browser_version` char(10) NOT NULL default '',
  KEY `tm` (`tm`,`year`,`month`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_waypoints`
-- 

CREATE TABLE `leonardo_waypoints` (
  `ID` mediumint(9) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `intName` varchar(100) NOT NULL default '',
  `lat` float NOT NULL default '0',
  `lon` float NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `countryCode` varchar(10) NOT NULL default 'GR',
  `location` varchar(100) NOT NULL default '',
  `intLocation` varchar(100) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `modifyDate` datetime NOT NULL default '2005-09-01 00:00:00',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
