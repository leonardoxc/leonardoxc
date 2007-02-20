-- phpMyAdmin SQL Dump
-- version 2.6.4-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: thales.thenet.gr
-- Generation Time: Feb 20, 2007 at 04:11 PM
-- Server version: 5.0.22
-- PHP Version: 4.1.2
-- 
-- Database: `paraglidingforum`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_areas`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_areas` (
  `areaID` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `descInt` varchar(255) NOT NULL,
  PRIMARY KEY  (`areaID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_areas_takeoffs`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_areas_takeoffs` (
  `areaID` mediumint(8) unsigned NOT NULL,
  `takeoffID` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_clubs` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs_flights`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL,
  `flightID` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_clubs_pilots`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_clubs_pilots` (
  `clubID` bigint(20) unsigned NOT NULL default '0',
  `pilotID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clubID`,`pilotID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_flights`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_flights` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `cat` smallint(5) unsigned NOT NULL default '1',
  `subcat` smallint(5) unsigned NOT NULL default '1',
  `category` smallint(5) unsigned NOT NULL default '2',
  `active` smallint(6) NOT NULL default '0',
  `dateAdded` datetime NOT NULL default '0000-00-00 00:00:00',
  `timesViewed` mediumint(9) NOT NULL default '0',
  `userID` mediumint(8) unsigned NOT NULL default '0',
  `filename` varchar(200) NOT NULL default '',
  `place` varchar(100) NOT NULL default '',
  `glider` varchar(50) NOT NULL default '',
  `gliderBrandID` smallint(5) unsigned NOT NULL default '0',
  `comments` text NOT NULL,
  `linkURL` varchar(200) NOT NULL default '',
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
  PRIMARY KEY  (`ID`),
  KEY `userID` (`userID`),
  KEY `takeoffID` (`takeoffID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_log`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_log` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_maps`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_maps` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_pilots`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_pilots` (
  `pilotID` bigint(20) NOT NULL default '0',
  `countryCode` char(2) NOT NULL default '',
  `NACid` int(10) unsigned NOT NULL default '0',
  `NACmemberID` bigint(20) unsigned NOT NULL default '0',
  `olcBirthDate` varchar(8) NOT NULL default '',
  `olcFirstName` varchar(100) NOT NULL default '',
  `olcLastName` varchar(100) NOT NULL default '',
  `olcCallSign` varchar(50) NOT NULL default '',
  `olcFilenameSuffix` varchar(4) NOT NULL default '',
  `olcAutoSubmit` tinyint(4) NOT NULL default '0',
  `FirstName` varchar(40) NOT NULL default '',
  `LastName` varchar(50) NOT NULL default '',
  `clubID` mediumint(8) unsigned NOT NULL default '0',
  `sponsorID` mediumint(8) unsigned NOT NULL default '0',
  `Sex` varchar(6) NOT NULL default '',
  `Birthdate` varchar(15) NOT NULL default '',
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
  PRIMARY KEY  (`pilotID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_servers`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_servers` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_stats`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_stats` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_users`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_users` (
  `user_id` mediumint(8) NOT NULL default '0',
  `user_active` tinyint(1) default '1',
  `username` varchar(25) NOT NULL default '',
  `user_password` varchar(32) NOT NULL default '',
  `user_lastvisit` int(11) NOT NULL default '0',
  `user_regdate` int(11) NOT NULL default '0',
  `user_level` tinyint(4) default '0',
  `user_style` tinyint(4) default NULL,
  `user_lang` varchar(255) default NULL,
  `user_dateformat` varchar(14) NOT NULL default 'd M Y H:i',
  `user_email` varchar(255) default NULL,
  `user_reg_email` varchar(255) NOT NULL default '',
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(32) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `leonardo_waypoints`
-- 

CREATE TABLE IF NOT EXISTS `leonardo_waypoints` (
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
  `modifyDate` date NOT NULL default '2005-09-01',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

