-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2014 at 03:41 PM
-- Server version: 5.5.15
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pgforum3`
--

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_airspace`
--

CREATE TABLE IF NOT EXISTS `leonardo_airspace` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `serial` tinyint(4) NOT NULL DEFAULT '0',
  `disabled` tinyint(4) NOT NULL DEFAULT '0',
  `updated` tinyint(4) NOT NULL DEFAULT '0',
  `Type` varchar(30) NOT NULL DEFAULT '',
  `Shape` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Comments` varchar(255) NOT NULL DEFAULT '',
  `minx` float NOT NULL DEFAULT '0',
  `miny` float NOT NULL DEFAULT '0',
  `maxx` float NOT NULL DEFAULT '0',
  `maxy` float NOT NULL DEFAULT '0',
  `Base` blob NOT NULL,
  `Top` blob NOT NULL,
  `Points` mediumblob NOT NULL,
  `Radius` float NOT NULL DEFAULT '0',
  `Latitude` float NOT NULL DEFAULT '0',
  `Longitude` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`Name`,`serial`),
  KEY `minx` (`minx`,`miny`,`maxx`,`maxy`),
  KEY `serial` (`serial`,`disabled`),
  KEY `serial_2` (`serial`,`disabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_areas`
--

CREATE TABLE IF NOT EXISTS `leonardo_areas` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `desc` text CHARACTER SET utf8 NOT NULL,
  `descInt` text CHARACTER SET utf8 NOT NULL,
  `areaType` smallint(5) unsigned NOT NULL DEFAULT '0',
  `min_lat` float NOT NULL DEFAULT '999',
  `max_lat` float NOT NULL DEFAULT '-999',
  `min_lon` float NOT NULL DEFAULT '999',
  `max_lon` float NOT NULL DEFAULT '-999',
  `center_lat` float NOT NULL DEFAULT '0',
  `center_lon` float NOT NULL DEFAULT '0',
  `radius` float NOT NULL DEFAULT '0',
  `polygon` text NOT NULL,
  `isInclusive` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `areaType` (`areaType`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_areas_takeoffs`
--

CREATE TABLE IF NOT EXISTS `leonardo_areas_takeoffs` (
  `areaID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `takeoffID` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_brands`
--

CREATE TABLE IF NOT EXISTS `leonardo_brands` (
  `brandID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brandName` varchar(100) NOT NULL,
  PRIMARY KEY (`brandID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs`
--

CREATE TABLE IF NOT EXISTS `leonardo_clubs` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET greek NOT NULL DEFAULT '',
  `intName` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `intDescription` text NOT NULL,
  `cat` smallint(5) unsigned NOT NULL DEFAULT '1',
  `location` varchar(60) NOT NULL DEFAULT '',
  `intLocation` varchar(60) NOT NULL DEFAULT '',
  `countryCode` varchar(30) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `club_admin` bigint(20) unsigned NOT NULL DEFAULT '0',
  `contact_person` varchar(255) NOT NULL DEFAULT '',
  `formula` smallint(6) NOT NULL DEFAULT '0',
  `formula_parameters` text NOT NULL,
  `areaID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs_flights`
--

CREATE TABLE IF NOT EXISTS `leonardo_clubs_flights` (
  `clubID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `flightID` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_clubs_pilots`
--

CREATE TABLE IF NOT EXISTS `leonardo_clubs_pilots` (
  `clubID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pilotID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pilotServerID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`clubID`,`pilotID`,`pilotServerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_comments`
--

CREATE TABLE IF NOT EXISTS `leonardo_comments` (
  `commentID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parentID` bigint(20) unsigned NOT NULL,
  `flightID` bigint(20) NOT NULL,
  `userID` mediumint(9) NOT NULL,
  `userServerID` mediumint(9) NOT NULL DEFAULT '0',
  `guestName` varchar(50) NOT NULL,
  `guestEmail` varchar(255) NOT NULL,
  `guestPass` varchar(40) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `title` tinyint(255) NOT NULL,
  `text` text NOT NULL,
  `languageCode` varchar(15) NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `flightID` (`flightID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights`
--

CREATE TABLE IF NOT EXISTS `leonardo_flights` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serverID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `originalURL` varchar(255) NOT NULL DEFAULT '',
  `originalKML` varchar(255) NOT NULL,
  `original_ID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat` smallint(5) unsigned NOT NULL DEFAULT '1',
  `subcat` smallint(5) unsigned NOT NULL DEFAULT '1',
  `category` smallint(5) unsigned NOT NULL DEFAULT '2',
  `gliderCertCategory` smallint(5) unsigned NOT NULL DEFAULT '0',
  `startType` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `active` smallint(6) NOT NULL DEFAULT '0',
  `excludeFrom` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateUpdated` datetime NOT NULL,
  `timesViewed` mediumint(9) NOT NULL DEFAULT '0',
  `userID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `originalUserID` varchar(30) NOT NULL,
  `userServerID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(200) NOT NULL DEFAULT '',
  `place` varchar(100) NOT NULL DEFAULT '',
  `glider` varchar(50) NOT NULL DEFAULT '',
  `gliderBrandID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comments` text NOT NULL,
  `commentsNum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `commentsEnabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `linkURL` varchar(200) NOT NULL DEFAULT '',
  `hasPhotos` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `takeoffID` mediumint(9) NOT NULL DEFAULT '0',
  `takeoffVinicity` float NOT NULL DEFAULT '0',
  `landingID` mediumint(9) NOT NULL DEFAULT '0',
  `landingVinicity` float NOT NULL DEFAULT '0',
  `DATE` date NOT NULL DEFAULT '0000-00-00',
  `timezone` float NOT NULL DEFAULT '0',
  `MAX_SPEED` float NOT NULL DEFAULT '0',
  `MEAN_SPEED` float NOT NULL DEFAULT '0',
  `MAX_ALT` int(11) NOT NULL DEFAULT '0',
  `MIN_ALT` int(11) NOT NULL DEFAULT '0',
  `TAKEOFF_ALT` int(11) NOT NULL DEFAULT '0',
  `MAX_VARIO` float NOT NULL DEFAULT '0',
  `MIN_VARIO` float NOT NULL DEFAULT '0',
  `LINEAR_DISTANCE` bigint(20) NOT NULL DEFAULT '0',
  `MAX_LINEAR_DISTANCE` bigint(20) NOT NULL DEFAULT '0',
  `START_TIME` mediumint(9) NOT NULL DEFAULT '0',
  `END_TIME` mediumint(9) NOT NULL DEFAULT '0',
  `DURATION` mediumint(9) NOT NULL DEFAULT '0',
  `BEST_FLIGHT_TYPE` varchar(30) NOT NULL DEFAULT '',
  `FLIGHT_KM` float NOT NULL DEFAULT '0',
  `FLIGHT_POINTS` float NOT NULL DEFAULT '0',
  `autoScore` float NOT NULL DEFAULT '0',
  `isLive` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `externalFlightType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `forceBounds` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `firstPointTM` int(10) unsigned NOT NULL DEFAULT '0',
  `firstLat` float NOT NULL,
  `firstLon` float NOT NULL,
  `lastPointTM` int(10) unsigned NOT NULL DEFAULT '0',
  `lastLat` float NOT NULL,
  `lastLon` float NOT NULL,
  `private` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `gpsTrack` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `grecord` smallint(6) NOT NULL DEFAULT '0',
  `validated` smallint(6) NOT NULL DEFAULT '0',
  `validationMessage` text NOT NULL,
  `airspaceCheck` tinyint(4) NOT NULL DEFAULT '0',
  `airspaceCheckFinal` tinyint(4) NOT NULL DEFAULT '0',
  `airspaceCheckMsg` text NOT NULL,
  `checkedBy` varchar(100) NOT NULL DEFAULT '',
  `NACid` int(10) unsigned NOT NULL DEFAULT '0',
  `NACclubID` bigint(20) NOT NULL DEFAULT '0',
  `hash` varchar(100) NOT NULL DEFAULT '',
  `batchOpProcessed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `takeoffID` (`takeoffID`),
  KEY `NACClubIndex` (`NACclubID`,`NACid`),
  KEY `userServerID` (`userServerID`),
  KEY `userID` (`userID`,`userServerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights_deleted`
--

CREATE TABLE IF NOT EXISTS `leonardo_flights_deleted` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serverID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `originalURL` varchar(255) NOT NULL DEFAULT '',
  `originalKML` varchar(255) NOT NULL,
  `original_ID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat` smallint(5) unsigned NOT NULL DEFAULT '1',
  `subcat` smallint(5) unsigned NOT NULL DEFAULT '1',
  `category` smallint(5) unsigned NOT NULL DEFAULT '2',
  `gliderCertCategory` smallint(5) unsigned NOT NULL DEFAULT '0',
  `startType` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `active` smallint(6) NOT NULL DEFAULT '0',
  `excludeFrom` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateUpdated` datetime NOT NULL,
  `timesViewed` mediumint(9) NOT NULL DEFAULT '0',
  `userID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `originalUserID` varchar(30) NOT NULL,
  `userServerID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(200) NOT NULL DEFAULT '',
  `place` varchar(100) NOT NULL DEFAULT '',
  `glider` varchar(50) NOT NULL DEFAULT '',
  `gliderBrandID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comments` text NOT NULL,
  `commentsNum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `commentsEnabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `linkURL` varchar(200) NOT NULL DEFAULT '',
  `hasPhotos` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `takeoffID` mediumint(9) NOT NULL DEFAULT '0',
  `takeoffVinicity` float NOT NULL DEFAULT '0',
  `landingID` mediumint(9) NOT NULL DEFAULT '0',
  `landingVinicity` float NOT NULL DEFAULT '0',
  `DATE` date NOT NULL DEFAULT '0000-00-00',
  `timezone` float NOT NULL DEFAULT '0',
  `MAX_SPEED` float NOT NULL DEFAULT '0',
  `MEAN_SPEED` float NOT NULL DEFAULT '0',
  `MAX_ALT` int(11) NOT NULL DEFAULT '0',
  `MIN_ALT` int(11) NOT NULL DEFAULT '0',
  `TAKEOFF_ALT` int(11) NOT NULL DEFAULT '0',
  `MAX_VARIO` float NOT NULL DEFAULT '0',
  `MIN_VARIO` float NOT NULL DEFAULT '0',
  `LINEAR_DISTANCE` bigint(20) NOT NULL DEFAULT '0',
  `MAX_LINEAR_DISTANCE` bigint(20) NOT NULL DEFAULT '0',
  `START_TIME` mediumint(9) NOT NULL DEFAULT '0',
  `END_TIME` mediumint(9) NOT NULL DEFAULT '0',
  `DURATION` mediumint(9) NOT NULL DEFAULT '0',
  `BEST_FLIGHT_TYPE` varchar(30) NOT NULL DEFAULT '',
  `FLIGHT_KM` float NOT NULL DEFAULT '0',
  `FLIGHT_POINTS` float NOT NULL DEFAULT '0',
  `autoScore` float NOT NULL DEFAULT '0',
  `isLive` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `externalFlightType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `forceBounds` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `firstPointTM` int(10) unsigned NOT NULL DEFAULT '0',
  `firstLat` float NOT NULL,
  `firstLon` float NOT NULL,
  `lastPointTM` int(10) unsigned NOT NULL DEFAULT '0',
  `lastLat` float NOT NULL,
  `lastLon` float NOT NULL,
  `private` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `gpsTrack` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `grecord` smallint(6) NOT NULL DEFAULT '0',
  `validated` smallint(6) NOT NULL DEFAULT '0',
  `validationMessage` text NOT NULL,
  `airspaceCheck` tinyint(4) NOT NULL DEFAULT '0',
  `airspaceCheckFinal` tinyint(4) NOT NULL DEFAULT '0',
  `airspaceCheckMsg` text NOT NULL,
  `checkedBy` varchar(100) NOT NULL DEFAULT '',
  `NACid` int(10) unsigned NOT NULL DEFAULT '0',
  `NACclubID` bigint(20) NOT NULL DEFAULT '0',
  `hash` varchar(100) NOT NULL DEFAULT '',
  `batchOpProcessed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `takeoffID` (`takeoffID`),
  KEY `NACClubIndex` (`NACclubID`,`NACid`),
  KEY `userServerID` (`userServerID`),
  KEY `userID` (`userID`,`userServerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_flights_score`
--

CREATE TABLE IF NOT EXISTS `leonardo_flights_score` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `flightID` bigint(20) unsigned NOT NULL,
  `method` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `isBest` tinyint(1) NOT NULL,
  `distance` float NOT NULL,
  `score` float NOT NULL,
  `turnpoint1` varchar(50) NOT NULL,
  `turnpoint2` varchar(50) NOT NULL,
  `turnpoint3` varchar(50) NOT NULL,
  `turnpoint4` varchar(50) NOT NULL,
  `turnpoint5` varchar(50) NOT NULL,
  `turnpoint6` varchar(50) NOT NULL,
  `turnpoint7` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `flightID` (`flightID`,`method`,`type`,`isBest`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_gliders`
--

CREATE TABLE IF NOT EXISTS `leonardo_gliders` (
  `gliderID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brandID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `gliderName` varchar(255) NOT NULL,
  `gliderSize` varchar(20) NOT NULL,
  `gliderCert` varchar(20) NOT NULL,
  PRIMARY KEY (`gliderID`),
  KEY `brandID` (`brandID`,`gliderName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_log`
--

CREATE TABLE IF NOT EXISTS `leonardo_log` (
  `transactionID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actionTime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `userID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `effectiveUserID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ItemType` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ItemID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ServerItemID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ActionID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ActionXML` text NOT NULL,
  `Modifier` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ModifierID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ServerModifierID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `Result` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ResultDescription` text NOT NULL,
  PRIMARY KEY (`transactionID`),
  KEY `ItemType` (`ItemType`,`ServerItemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_maps`
--

CREATE TABLE IF NOT EXISTS `leonardo_maps` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL DEFAULT '',
  `leftX` double(10,2) NOT NULL DEFAULT '0.00',
  `topY` double(10,2) NOT NULL DEFAULT '0.00',
  `rightX` double(10,2) NOT NULL DEFAULT '0.00',
  `bottomY` double(10,2) NOT NULL DEFAULT '0.00',
  `UTMzone` smallint(6) NOT NULL DEFAULT '0',
  `pixelWidth` mediumint(9) NOT NULL DEFAULT '0',
  `pixelHeight` mediumint(9) NOT NULL DEFAULT '0',
  `metersPerPixel` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`,`filename`),
  UNIQUE KEY `filename` (`filename`),
  KEY `UTMzone` (`UTMzone`),
  KEY `metersPerPixel` (`metersPerPixel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_nac_clubs`
--

CREATE TABLE IF NOT EXISTS `leonardo_nac_clubs` (
  `NAC_ID` mediumint(9) NOT NULL DEFAULT '0',
  `clubID` bigint(20) NOT NULL DEFAULT '0',
  `clubName` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`NAC_ID`,`clubID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_photos`
--

CREATE TABLE IF NOT EXISTS `leonardo_photos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `flightID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `tm` int(10) unsigned NOT NULL DEFAULT '0',
  `lat` float NOT NULL DEFAULT '0',
  `lon` float NOT NULL DEFAULT '0',
  `alt` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `flightID` (`flightID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_pilots`
--

CREATE TABLE IF NOT EXISTS `leonardo_pilots` (
  `pilotID` bigint(20) NOT NULL DEFAULT '0',
  `serverID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `countryCode` char(2) NOT NULL DEFAULT '',
  `CIVL_ID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `CIVL_NAME` varchar(80) DEFAULT NULL,
  `NACid` int(10) unsigned NOT NULL DEFAULT '0',
  `NACmemberID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `NACclubID` bigint(20) NOT NULL DEFAULT '0',
  `FirstName` varchar(40) NOT NULL DEFAULT '',
  `LastName` varchar(50) NOT NULL DEFAULT '',
  `FirstNameEn` varchar(40) NOT NULL,
  `LastNameEn` varchar(50) NOT NULL,
  `NickName` varchar(25) NOT NULL,
  `clubID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `Sex` varchar(6) NOT NULL DEFAULT '',
  `Birthdate` varchar(15) NOT NULL DEFAULT '',
  `BirthdateHideMask` varchar(10) NOT NULL DEFAULT 'xx.xx.xxxx',
  `PilotPhoto` varchar(30) NOT NULL DEFAULT '',
  `FirstOlcYear` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pilotID`,`serverID`),
  KEY `FirstName` (`FirstName`,`LastName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_pilots_info`
--

CREATE TABLE IF NOT EXISTS `leonardo_pilots_info` (
  `pilotID` bigint(20) NOT NULL DEFAULT '0',
  `serverID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sponsor` varchar(255) DEFAULT NULL,
  `Occupation` varchar(100) NOT NULL DEFAULT '',
  `MartialStatus` varchar(20) NOT NULL DEFAULT '',
  `OtherInterests` longtext NOT NULL,
  `PersonalWebPage` varchar(150) NOT NULL DEFAULT '',
  `PilotLicence` varchar(100) NOT NULL DEFAULT '',
  `BestMemory` longtext NOT NULL,
  `WorstMemory` longtext NOT NULL,
  `Training` varchar(200) NOT NULL DEFAULT '',
  `personalDistance` varchar(150) NOT NULL DEFAULT '',
  `personalHeight` varchar(150) NOT NULL DEFAULT '',
  `glider` varchar(200) NOT NULL DEFAULT '',
  `FlyingSince` varchar(100) NOT NULL DEFAULT '',
  `HoursFlown` varchar(50) NOT NULL DEFAULT '',
  `HoursPerYear` varchar(50) NOT NULL DEFAULT '',
  `FavoriteLocation` varchar(250) NOT NULL DEFAULT '',
  `UsualLocation` varchar(150) NOT NULL DEFAULT '',
  `FavoriteBooks` varchar(150) NOT NULL DEFAULT '',
  `FavoriteActors` varchar(150) NOT NULL DEFAULT '',
  `FavoriteSingers` varchar(150) NOT NULL DEFAULT '',
  `FavoriteMovies` varchar(150) NOT NULL DEFAULT '',
  `FavoriteSite` varchar(150) NOT NULL DEFAULT '',
  `Sign` varchar(40) NOT NULL DEFAULT '',
  `Spiral` varchar(60) NOT NULL DEFAULT '',
  `Bline` varchar(100) NOT NULL DEFAULT '',
  `FullStall` varchar(100) NOT NULL DEFAULT '',
  `Sat` varchar(100) NOT NULL DEFAULT '',
  `AsymmetricSpiral` varchar(100) NOT NULL DEFAULT '',
  `Spin` varchar(100) NOT NULL DEFAULT '',
  `OtherAcro` varchar(150) NOT NULL DEFAULT '',
  `camera` varchar(150) NOT NULL DEFAULT '',
  `camcorder` varchar(150) NOT NULL DEFAULT '',
  `Vario` varchar(60) NOT NULL DEFAULT '',
  `GPS` varchar(60) NOT NULL DEFAULT '',
  `Harness` varchar(60) NOT NULL DEFAULT '',
  `Reserve` varchar(60) NOT NULL DEFAULT '',
  `Helmet` varchar(60) NOT NULL DEFAULT '',
  `commentsEnabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pilotID`,`serverID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_queue`
--

CREATE TABLE IF NOT EXISTS `leonardo_queue` (
  `jobID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `jobType` varchar(30) NOT NULL,
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `timeCreated` datetime NOT NULL,
  `timeProccessed` datetime NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '0',
  `param1` text NOT NULL,
  `param2` text NOT NULL,
  `param3` text NOT NULL,
  PRIMARY KEY (`jobID`),
  KEY `userID` (`userID`,`jobType`,`param1`(150),`param2`(150))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_remote_pilots`
--

CREATE TABLE IF NOT EXISTS `leonardo_remote_pilots` (
  `remoteServerID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `remoteUserID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `serverID` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userID` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`remoteServerID`,`remoteUserID`,`serverID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_servers`
--

CREATE TABLE IF NOT EXISTS `leonardo_servers` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lastPullUpdateID` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_sessions`
--

CREATE TABLE IF NOT EXISTS `leonardo_sessions` (
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
-- Table structure for table `leonardo_stats`
--

CREATE TABLE IF NOT EXISTS `leonardo_stats` (
  `tm` bigint(20) unsigned NOT NULL DEFAULT '0',
  `year` smallint(5) unsigned NOT NULL DEFAULT '0',
  `month` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `day` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `userID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sessionID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `visitorID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `op` char(25) NOT NULL DEFAULT '',
  `flightID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `executionTime` float unsigned NOT NULL DEFAULT '0',
  `os` char(20) NOT NULL DEFAULT '',
  `browser` char(15) NOT NULL DEFAULT '',
  `browser_version` char(10) NOT NULL DEFAULT '',
  KEY `tm` (`tm`,`year`,`month`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_temp_users`
--

CREATE TABLE IF NOT EXISTS `leonardo_temp_users` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_civlid` int(6) NOT NULL,
  `user_civlname` varchar(150) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_firstname` varchar(25) NOT NULL,
  `user_lastname` varchar(25) NOT NULL,
  `user_nickname` varchar(25) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_nation` varchar(5) NOT NULL,
  `user_gender` varchar(5) NOT NULL,
  `user_birthdate` varchar(10) NOT NULL,
  `user_session_time` int(11) NOT NULL DEFAULT '0',
  `user_regdate` int(11) NOT NULL DEFAULT '0',
  `user_email` varchar(255) DEFAULT NULL,
  `user_actkey` varchar(32) DEFAULT NULL,
  `user_newpasswd` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_thermals`
--

CREATE TABLE IF NOT EXISTS `leonardo_thermals` (
  `id` bigint(20) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `name` char(6) NOT NULL,
  `climbrate` smallint(6) NOT NULL,
  `climbseconds` smallint(6) NOT NULL,
  `climbmeters` smallint(6) NOT NULL,
  `windsourcedeg` smallint(6) NOT NULL,
  `windspeed` tinyint(4) NOT NULL,
  `class` char(1) NOT NULL,
  `icon` tinyint(4) NOT NULL,
  `createddatetime` datetime NOT NULL,
  `altitude` smallint(6) NOT NULL,
  `notes` text NOT NULL,
  KEY `class` (`class`),
  KEY `latitude` (`latitude`,`longitude`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_users`
--

CREATE TABLE IF NOT EXISTS `leonardo_users` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_active` tinyint(1) DEFAULT '1',
  `username` varchar(25) NOT NULL,
  `user_password` varchar(34) NOT NULL,
  `user_session_time` int(11) NOT NULL DEFAULT '0',
  `user_session_page` smallint(5) NOT NULL DEFAULT '0',
  `user_lastvisit` int(11) NOT NULL DEFAULT '0',
  `user_regdate` int(11) NOT NULL DEFAULT '0',
  `user_level` tinyint(4) DEFAULT '0',
  `user_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_timezone` decimal(5,2) NOT NULL DEFAULT '0.00',
  `user_style` tinyint(4) DEFAULT NULL,
  `user_lang` varchar(255) DEFAULT NULL,
  `user_dateformat` varchar(14) NOT NULL DEFAULT 'd M Y H:i',
  `user_new_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_last_privmsg` int(11) NOT NULL DEFAULT '0',
  `user_login_tries` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_last_login_try` int(11) NOT NULL DEFAULT '0',
  `user_emailtime` int(11) DEFAULT NULL,
  `user_viewemail` tinyint(1) DEFAULT NULL,
  `user_attachsig` tinyint(1) DEFAULT NULL,
  `user_allowhtml` tinyint(1) DEFAULT '1',
  `user_allowbbcode` tinyint(1) DEFAULT '1',
  `user_allowsmile` tinyint(1) DEFAULT '1',
  `user_allowavatar` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_viewonline` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_popup_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_rank` int(11) DEFAULT '0',
  `user_avatar` varchar(100) DEFAULT NULL,
  `user_avatar_type` tinyint(4) NOT NULL DEFAULT '0',
  `user_email` varchar(255) DEFAULT NULL,
  `user_icq` varchar(15) DEFAULT NULL,
  `user_website` varchar(100) DEFAULT NULL,
  `user_from` varchar(100) DEFAULT NULL,
  `user_sig` text,
  `user_sig_bbcode_uid` char(10) DEFAULT NULL,
  `user_aim` varchar(255) DEFAULT NULL,
  `user_yim` varchar(255) DEFAULT NULL,
  `user_msnm` varchar(255) DEFAULT NULL,
  `user_occ` varchar(100) DEFAULT NULL,
  `user_interests` varchar(255) DEFAULT NULL,
  `user_actkey` varchar(32) DEFAULT NULL,
  `user_newpasswd` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leonardo_waypoints`
--

CREATE TABLE IF NOT EXISTS `leonardo_waypoints` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `intName` varchar(100) NOT NULL DEFAULT '',
  `lat` float NOT NULL DEFAULT '0',
  `lon` float NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `countryCode` varchar(10) NOT NULL DEFAULT 'GR',
  `location` varchar(100) NOT NULL DEFAULT '',
  `intLocation` varchar(100) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `modifyDate` date NOT NULL DEFAULT '2005-09-01',
  PRIMARY KEY (`ID`),
  KEY `lat` (`lat`,`lon`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
